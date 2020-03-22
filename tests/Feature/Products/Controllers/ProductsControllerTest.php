<?php

namespace Tests\Feature\Products\Controllers;

use Tests\TestCase;
use App\Users\Entities\User;
use App\Products\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUsersCanCreateProducts()
    {
        $user = factory(User::class)->create();

        $data = factory(Product::class)
            ->state('withVariantData')
            ->raw();

        $this->actingAs($user)
            ->postJson('api/v1/products', $data)
            ->assertCreated();

        $this->assertDatabaseHas('products', ['name' => $data['name']]);
    }

    public function testItListsTheDetailsOfAProduct()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)->create(['user_id' => $user]);

        $this->actingAs($user)
            ->getJson("api/v1/products/{$product->id}")
            ->assertOk()
            ->assertJson(['id' => $product->id]);
    }

    public function testItUpdatesAnExistingProduct()
    {
        $product = factory(Product::class)->create();

        $this->actingAs($product->user)
            ->putJson("api/v1/products/{$product->id}", ['name' => 'updated_name'])
            ->assertOk();

        $this->assertEquals($product->fresh()->name, 'updated_name');
    }
}
