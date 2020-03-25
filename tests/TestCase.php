<?php

namespace Tests;

use App\Users\Entities\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Mail;
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
     * Makes a request while acting as a given user
     * @return $this
     */
    public function actingAsUser(User $user = null)
    {
        Sanctum::actingAs($user ?: factory(User::class)->create());

        return $this;
    }
}
