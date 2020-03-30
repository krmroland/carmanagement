<?php

namespace Tests\Feature\Products\Variants\Controllers;

use Tests\TestCase;
use App\Products\Entities\Product;
use App\Products\Entities\ProductVariant;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariantsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_all_product_variants()
    {
        $product = factory(Product::class)->create();

        factory(ProductVariant::class, 3)->create(['product_id' => $product]);

        // control test for non related product
        factory(ProductVariant::class)
            ->state('withProduct')
            ->create();

        $this->actingAsAdmin()
            ->getJson("api/v1/products/$product->id/variants")
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_it_adds_a_variant_to_an_existing_product()
    {
        $product = factory(Product::class)->create();

        factory(ProductVariant::class, 3)->create(['product_id' => $product]);

        // control test for non related product

        $variant = factory(ProductVariant::class)->raw();

        $this->actingAsAdmin()
            ->postJson("api/v1/products/$product->id/variants", $variant)
            ->assertCreated();

        $this->assertEquals($product->variants()->count(), 1);
    }
}
