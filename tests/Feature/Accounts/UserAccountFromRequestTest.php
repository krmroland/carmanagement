<?php

namespace Tests\Feature\Accounts;

use Tests\TestCase;
use App\Users\Entities\User;
use App\Accounts\UserAccountFromRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAccountFromRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testItResolvesTheUserAccountFromTheRequest()
    {
        $user = factory(User::class)->create();

        $this->actingAsUser($user);

        $this->assertTrue($user->account->is(app(UserAccountFromRequest::class)->get()));
    }
}
