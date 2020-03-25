<?php

namespace Tests\Feature\Auth\Controllers;

use Tests\TestCase;
use App\Users\Entities\User;
use Illuminate\Cache\RateLimiter;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logins_an_existing_user()
    {
        $user = factory(User::class)->create(['password' => bcrypt('secret')]);

        $this->postJson('auth/login', [
            'email' => $user->email,
            'password' => 'secret',
        ])->assertOk();

        $this->assertAuthenticated();
    }

    public function test_login_fails_with_wrong_email()
    {
        $user = factory(User::class)->create(['password' => bcrypt('secret')]);

        $this->postJson('auth/login', [
            'email' => 'unknownemail@test.com',
            'password' => 'secret',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'These credentials do not match our records.',
            ]);
    }

    public function test_it_returns_the_currently_authenticated_user()
    {
        $user = factory(User::class)->create(['password' => bcrypt('secret')]);

        $this->postJson('auth/login', [
            'email' => $user->email,
            'password' => 'secret',
        ])->assertOk();

        $this->assertAuthenticated();

        $this->get('api/auth/user')->assertOk();
    }
}
