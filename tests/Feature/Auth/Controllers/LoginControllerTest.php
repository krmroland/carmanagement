<?php

namespace Tests\Feature\Auth\Controllers;

use Tests\TestCase;
use App\Users\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItLogsInAUserThroughApi()
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
