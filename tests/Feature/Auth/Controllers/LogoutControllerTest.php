<?php

namespace Tests\Feature\Auth\Controllers;

use Tests\TestCase;
use App\Users\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItLogsOutAUser()
    {
        $this->actingAs(factory(User::class)->create());

        $this->assertAuthenticated();

        $this->postJson('auth/logout')->assertStatus(204);

        $this->assertGuest();
    }
}
