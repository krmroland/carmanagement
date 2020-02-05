<?php

namespace Tests\Feature\Products\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use App\Products\Models\Product;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanCreateAPersonalProduct()
    {
        $user = factory(User::class)->create();

        $data = factory(Product::class)
            ->state('withVariantData')
            ->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$user->getUniqueName()}/products", $data)
            ->assertCreated();

        $this->assertDatabaseHas('products', ['name' => $data['name']]);
    }

    public function testAOrganizationUsersCanCreateAProductInAnOrganization()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create(['user_id' => $user]);

        $data = factory(Product::class)
            ->state('withVariantData')
            ->raw();

        $this->actingAs($user)

            ->postJson("api/v1/@{$organization->getUniqueName()}/products", $data)
            ->assertCreated();
    }

    public function testNonOrganizationUsersCannotCreateOrganizationProducts()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $data = factory(Product::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/products", $data)
            ->assertForbidden();
    }

    public function testOrganizationUsersWithWritePermissionsCanCreateProducts()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user, ['products.write']);

        $data = factory(Product::class)
            ->state('withVariantData')
            ->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/products", $data)
            ->assertCreated();
    }

    public function testCreateFailsForOrganizationMemebersWithNoWritePermission()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $data = factory(Product::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/products", $data)
            ->assertForbidden();
    }

    public function testItLoadsAllUserProducts()
    {
        // two for some other users
        factory(Product::class, 2)->create();

        $user = factory(User::class)->create();

        factory(Product::class, 3)->create($user->getMorphAttributes('owner'));

        $this->actingAs($user)
            ->getJson("api/v1/@{$user->getUniqueName()}/products")
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function testGetAllProductsFailsForNonOrganizationMemebers()
    {
        // two for some other users
        factory(Product::class, 2)->create();

        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        factory(Product::class, 2)->create($organization->getMorphAttributes('owner'));

        $this->actingAs($user)
            ->getJson("api/v1/@{$organization->getUniqueName()}/products")
            ->assertForbidden();
    }

    public function testItListsTheDetailsOfAProduct()
    {
        // two for some other users
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create($user->getMorphAttributes('owner'));

        $this->actingAs($user)
            ->getJson("api/v1/@{$user->getUniqueName()}/products/{$product->id}")
            ->assertOk()
            ->assertJson(['id' => $product->id]);
    }

    public function testItUpdatesAnExistingProduct()
    {
        // two for some other users
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create($user->getMorphAttributes('owner'));

        $data = factory(Product::class)->raw();

        $this->actingAs($user)
            ->putJson("api/v1/@{$user->getUniqueName()}/products/{$product->id}", $data)
            ->assertOk();

        $this->assertEquals($product->fresh()->name, $data['name']);
    }
}
