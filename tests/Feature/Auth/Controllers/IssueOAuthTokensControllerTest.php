<?php

namespace Tests\Feature\Auth\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IssueOAuthTokensControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_it_exchanges_a_righ_username_and_password_with_token()
    {
        $user = factory(User::class)->create();

        $this->postJson('api/v1/auth/token', [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => $this->faker()->userAgent,
        ])
        ->dump()
            ->assertOk()
          ;
    }
}
