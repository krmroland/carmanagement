<?php

namespace Tests\Feature\Auth\Controllers;

use Tests\TestCase;
use App\Users\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanRegisterThemSelf()
    {
        $data = factory(User::class)->raw();

        $this->postJson('register', $data)->assertCreated();
    }
}
