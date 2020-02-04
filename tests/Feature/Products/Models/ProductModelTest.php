<?php

namespace Tests\Feature\Products\Models;

use Tests\TestCase;
use App\Users\Models\User;
use App\Products\Models\Product;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_fails_if_identification_exists_already()
    {
        $user = factory(User::class)->create();

        $data = factory(Product::class)->raw(['identifier' => '12345']);

        $user->products()->create($data);

        // try to create a gain
        $this->expectException(ValidationException::class);

        $user->products()->create($data);
    }
    public function test_same_identifier_doesnt_fail_on_updating_for_same_user()
    {
        $user = factory(User::class)->create();

        $data = factory(Product::class)->raw(['identifier' => '12345']);

        $product = $user->products()->create($data);

        $product->update(['identifier' => '12345']);

        $this->assertEquals($product->fresh()->identifier, '12345');
    }
    public function test_different_users_can_use_the_same_indentifier()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $data = factory(Product::class)->raw(['identifier' => '12']);

        $user->products()->create($data);

        $product = $organization->products()->create($data);

        $this->assertEquals($product->identifier, '12');
    }
}
