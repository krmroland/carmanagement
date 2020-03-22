<?php

namespace Tests\Feature\Products\Actions;

use Tests\TestCase;
use App\Users\Entities\User;
use App\Products\Models\Product;
use App\Products\Models\ProductVariant;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserActionsTest extends TestCase
{
    use RefreshDatabase;

    public function testItAddsAUserToAVariant()
    {
        $variant = factory(ProductVariant::class)->create();

        $user = factory(User::class)->create();

        $variant->userActions()->add($user);

        $this->assertDatabaseHas('product_variant_users', [
            'product_variant_id' => $variant->id,
            'user_id' => $user->id,
        ]);
    }

    public function testHasUserReturnsTrueIfUserExists()
    {
        $variant = factory(ProductVariant::class)->create();

        $user = factory(User::class)->create();

        $variant->userActions()->add($user);

        $this->assertTrue($variant->userActions()->has($user));
    }

    public function testAddingAnExistingUserFails()
    {
        $variant = factory(ProductVariant::class)->create();

        $user = factory(User::class)->create();

        $variant->userActions()->add($user);

        $this->expectException(ValidationException::class);

        $variant->userActions()->add($user);
    }
}
