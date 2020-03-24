<?php

namespace Tests\Feature\Auth\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_registers_a_new_user()
    {
        $user = [
            'name' => 'John Doe',
            'email' => 'test@email.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $this->postJson('auth/register', $user)->assertCreated();
    }

    public function test_it_logins_in_a_user_after_registering_them()
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
