<?php

namespace Tests\Feature\Products\Models;

use Tests\TestCase;
use App\Users\Models\User;
use App\Products\Models\Product;
use App\Users\Models\Organization;
use App\Products\Models\ProductVariant;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariantModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_fails_if_identification_for_same_project_exists_already()
    {
        $data = factory(ProductVariant::class)->raw(['identifier' => '12345']);

        $product = factory(Product::class)->create();

        $product->variants()->create($data);

        // try to create a gain
        $this->expectException(ValidationException::class);

        $product->variants()->create($data);
    }
    public function test_same_identifier_doesnt_fail_on_updating_for_same_product()
    {
        $product = factory(Product::class)->create();

        $data = factory(ProductVariant::class)->raw(['identifier' => '12345']);

        $variant = $product->variants()->create($data);

        $variant->update(['identifier' => '12345']);

        $this->assertEquals($variant->fresh()->identifier, '12345');
    }
    public function test_different_products_can_use_the_same_indentifier()
    {
        $product = factory(Product::class)->create();

        $secondProduct = factory(Product::class)->create();

        $data = factory(ProductVariant::class)->raw(['identifier' => '12']);

        $product->variants()->create($data);

        $variant = $secondProduct->variants()->create($data);

        $this->assertEquals($variant->identifier, '12');
    }
}
