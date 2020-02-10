<?php

namespace Tests\Feature\Auth\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APILoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testItAuthenticatesAGivenUserThroughApi()
    {
        $user = factory(User::class)->create();

        $this->postJson('api/v1/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertOk();
    }
}
