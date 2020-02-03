<?php

namespace Tests;

use App\Users\Models\User;
use Illuminate\Support\Arr;
use Laravel\Airlock\Airlock;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

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
        Airlock::actingAs(factory(User::class)->create(), ['*']);

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
}
