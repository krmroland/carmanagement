<?php

namespace Tests\Feature\Auth\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanRegisterThemSelf()
    {
        $data = factory(User::class)->raw();

        $this->postJson('api/v1/auth/register', $data)->assertCreated();
    }
}
