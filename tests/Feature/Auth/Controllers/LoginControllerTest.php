<?php

namespace Tests\Feature\Auth\Controllers;

use Tests\TestCase;
use App\Users\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItLoginsAnExistingUser()
    {
        $user = factory(User::class)->create(['password' => bcrypt('secret')]);

        $this->postJson('auth/login', [
            'email' => $user->email,
            'password' => 'secret',
        ])->assertOk();

        $this->assertAuthenticated();
    }

    public function testLoginFailsWithWrongEmail()
    {
        $this->postJson('auth/login', [
            'email' => 'unknownemail@test.com',
            'password' => 'secret',
        ])
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'email' => 'These credentials do not match our records.',
            ]);
    }

    public function testItReturnsTheCurrentlyAuthenticatedUser()
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
