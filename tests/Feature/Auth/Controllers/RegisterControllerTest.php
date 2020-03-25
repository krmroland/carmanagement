<?php

namespace Tests\Feature\Auth\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItRegistersANewUser()
    {
        $user = [
            'name' => 'John Doe',
            'email' => 'test@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->postJson('auth/register', $user)->assertCreated();
    }

    public function testItLoginsInAUserAfterRegisteringThem()
    {
        $this->assertGuest();

        $user = [
            'name' => 'John Doe',
            'email' => 'test@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->postJson('auth/register', $user)->assertCreated();

        $this->assertAuthenticated();
    }
}
