<?php

namespace Tests\Feature\Auth\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_logs_in_a_user_through_api()
    {
        $user = factory(User::class)->create();

        $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertOk()
            ->assertJson(['message' => 'Authentication was successful']);
    }
}
