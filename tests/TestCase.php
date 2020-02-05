<?php

namespace Tests;

use App\Users\Models\User;
use Illuminate\Support\Arr;
use Laravel\Airlock\Airlock;
use App\Products\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Products\Models\ProductVariant;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    /**
     * Act as a user with a given set of permissions
     * @param  array $abilities
     * @param  User $user
     * @return $this
     */
    public function actingAsUserWithPermission($abilities = [], User $user = null)
    {
        Airlock::actingAs($user ?: factory(User::class)->create(), Arr::wrap($abilities));

        return $this;
    }

    /**
     * Make a request while acting as a admin
     * @return $this
     */
    public function actingAsAdmin()
    {
        Airlock::actingAs(factory(User::class)->create(['is_admin' => true]));

        return $this;
    }

    /**
     * Makes a request while acting as a given user
     * @return $this
     */
    public function actingAsUser(User $user = null)
    {
        Airlock::actingAs($user ?: factory(User::class)->create());

        return $this;
    }

    /**
     * Crates a product variant for a user
     * @param  array  $attributes
     * @return \App\Products\Models\ProductVariant
     */
    public function createProductVariantForUser(User $user, $attributes = [])
    {
        $product = factory(Product::class)->create($user->getMorphAttributes('owner'));

        return factory(ProductVariant::class)->create(['product_id' => $product] + $attributes);
    }
}
