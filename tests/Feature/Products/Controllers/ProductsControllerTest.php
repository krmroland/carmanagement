<?php

namespace Tests\Feature\Products\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use App\Products\Models\Product;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test__users_can_create_a_personal_product()
    {
        $user = factory(User::class)->create();

        $data = factory(Product::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$user->getUniqueName()}/products", $data)
            ->assertCreated();

        $this->assertDatabaseHas('products', ['name' => $data['name']]);
    }

    public function test_a_organization_users_can_create_a_product_in_an_organization()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create(['user_id' => $user]);

        $data = factory(Product::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/products", $data)
            ->assertCreated();
    }

    public function test_non_organization_users_cannot_create_organization_products()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $data = factory(Product::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/products", $data)
            ->assertForbidden();
    }
    public function test_organization_users_with_write_permissions_can_create_products()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user, ['products.write']);

        $data = factory(Product::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/products", $data)
            ->assertCreated();
    }
    public function test_create_fails_for_organization_memebers_with_no_write_permission()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $data = factory(Product::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/products", $data)
            ->assertForbidden();
    }

    public function test_it_loads_all_user_products()
    {
        // two for some other users
        factory(Product::class, 2)->create();

        $user = factory(User::class)->create();

        factory(Product::class, 3)->create($user->getMorhpAttributes('owner'));

        $this->actingAs($user)
            ->getJson("api/v1/@{$user->getUniqueName()}/products")
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_get_all_products_fails_for_non_organization_memebers()
    {
        // two for some other users
        factory(Product::class, 2)->create();

        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        factory(Product::class, 2)->create($organization->getMorhpAttributes('owner'));

        $this->actingAs($user)
            ->getJson("api/v1/@{$organization->getUniqueName()}/products")
            ->assertForbidden();
    }

    public function test_it_lists_the_details_of_a_product()
    {
        // two for some other users
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create($user->getMorhpAttributes('owner'));

        $this->actingAs($user)
            ->getJson("api/v1/@{$user->getUniqueName()}/products/{$product->id}")
            ->assertOk()
            ->assertJson(['id' => $product->id]);
    }
    public function test_it_updates_an_existing_product()
    {
        // two for some other users
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create($user->getMorhpAttributes('owner'));

        $data = factory(Product::class)->raw();

        $this->actingAs($user)
            ->putJson("api/v1/@{$user->getUniqueName()}/products/{$product->id}", $data)
            ->assertOk();

        $this->assertEquals($product->fresh()->name, $data['name']);
    }
}
