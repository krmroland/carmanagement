<?php

namespace Tests\Feature\Products\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use App\Products\Models\Product;
use App\Users\Models\Organization;
use App\Products\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariantsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesANewProductVariant()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create($user->getMorphAttributes('owner'));

        $data = factory(ProductVariant::class)->raw();

        $this->actingAs($user)
            ->postJson("/api/v1/products/{$product->id}/variants", $data)
            ->assertCreated();

        $this->assertEquals($product->variants->first()->identifier, $data['identifier']);
    }

    public function testNonProductOwnersCantCreateVariants()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create(
            with(factory(User::class)->create())->getMorphAttributes('owner')
        );

        $data = factory(ProductVariant::class)->raw();

        $this->actingAs($user)
            ->postJson("/api/v1/products/{$product->id}/variants", $data)
            ->assertForbidden();
    }

    public function testNonOrganizationMemebersCantCreateVariants()
    {
        $user = factory(User::class)->create();

        $organizaton = factory(Organization::class)->create();

        $product = factory(Product::class)->create($organizaton->getMorphAttributes('owner'));

        $data = factory(ProductVariant::class)->raw();

        $this->actingAs($user)
            ->postJson("/api/v1/products/{$product->id}/variants", $data)
            ->assertForbidden();
    }

    public function testOrganizationMemebersWithWritePermissionCanCreateVariants()
    {
        $user = factory(User::class)->create();

        $organizaton = factory(Organization::class)->create();

        $organizaton->addMember($user, ['products.write']);

        $product = factory(Product::class)->create($organizaton->getMorphAttributes('owner'));

        $data = factory(ProductVariant::class)->raw();

        $this->actingAs($user)
            ->postJson("/api/v1/products/{$product->id}/variants", $data)
            ->assertCreated();
    }

    public function testItUpdatesAnExistingVariant()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create($user->getMorphAttributes('owner'));

        $variant = factory(ProductVariant::class)->create(['product_id' => $product]);

        $data = factory(ProductVariant::class)->raw();

        $this->actingAs($user)
            ->putJson("/api/v1/products/{$product->id}/variants/{$variant->id}", $data)
            ->assertOk();

        $this->assertEquals($variant->fresh()->identifier, $data['identifier']);
    }

    public function testItDeletesAnExistingVariant()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create($user->getMorphAttributes('owner'));

        $variant = factory(ProductVariant::class)->create(['product_id' => $product]);

        $this->actingAs($user)
            ->deleteJson("/api/v1/products/{$product->id}/variants/{$variant->id}")
            ->assertOk();

        $this->assertFalse($variant->exists());
    }
}
