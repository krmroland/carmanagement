<?php

namespace Tests\Feature\Products\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use App\Products\Models\Product;
use App\Products\Models\ProductVariant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariantsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesANewProductVariant()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create($user->getMorhpAttributes('owner'));

        $data = factory(ProductVariant::class)->raw();

        $this->actingAs($user)
            ->postJson("/api/v1/products/{$product->id}/variants", $data)
            ->assertCreated();

        $this->assertEquals($product->variants->first()->identifier, $data['identifier']);
    }

    public function testItUpdatesAnExistingVariant()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create($user->getMorhpAttributes('owner'));

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

        $product = factory(Product::class)->create($user->getMorhpAttributes('owner'));

        $variant = factory(ProductVariant::class)->create(['product_id' => $product]);

        $this->actingAs($user)
            ->deleteJson("/api/v1/products/{$product->id}/variants/{$variant->id}")
            ->assertOk();

        $this->assertFalse($variant->exists());
    }
}
