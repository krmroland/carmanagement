<?php

namespace Tests\Feature\Products\Models;

use Tests\TestCase;
use App\Products\Models\Product;
use App\Products\Models\ProductVariant;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariantModelTest extends TestCase
{
    use RefreshDatabase;

    public function testValidationFailsIfIdentificationForSameProjectExistsAlready()
    {
        $data = factory(ProductVariant::class)->raw(['identifier' => '12345']);

        $product = factory(Product::class)->create();

        $product->variants()->create($data);

        // try to create a gain
        $this->expectException(ValidationException::class);

        $product->variants()->create($data);
    }

    public function testSameIdentifierDoesntFailOnUpdatingForSameProduct()
    {
        $product = factory(Product::class)->create();

        $data = factory(ProductVariant::class)->raw(['identifier' => '12345']);

        $variant = $product->variants()->create($data);

        $variant->update(['identifier' => '12345']);

        $this->assertEquals($variant->fresh()->identifier, '12345');
    }

    public function testDifferentProductsCanUseTheSameIndentifier()
    {
        $product = factory(Product::class)->create();

        $secondProduct = factory(Product::class)->create();

        $data = factory(ProductVariant::class)->raw(['identifier' => '12']);

        $product->variants()->create($data);

        $variant = $secondProduct->variants()->create($data);

        $this->assertEquals($variant->identifier, '12');
    }
}
