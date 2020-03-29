<?php

namespace Tests\Feature\Products\Controllers;

use Tests\TestCase;
use App\Users\Entities\User;
use App\Products\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItSuccessfullyCreatesANewProduct()
    {
        $data = factory(Product::class)
            ->state('withVariantData')
            ->raw();

        $this->actingAsUser()
            ->postJson('api/v1/products', $data)
            ->assertCreated();
    }

    public function testItListsAllAvailableProductsForCurrentUserAccount()
    {
        $user = factory(User::class)->create();
        factory(Product::class, 2)->create(); //control
        factory(Product::class, 3)
            ->state('withVariantData')
            ->create(['account_id' => $user->account]);

        $this->actingAsUser($user)
            ->getJson('api/v1/products')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function testItShowsTheDetailsOfAproduct()
    {
        $user = factory(User::class)->create();

        $product = factory(Product::class)
            ->state('withVariantData')
            ->create(['account_id' => $user->account]);

        $this->actingAsUser($user)
            ->getJson("api/v1/products/{$product->id}")
            ->assertOk();
    }
}
