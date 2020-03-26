<?php

namespace Tests\Feature\Accounts;

use Tests\TestCase;
use App\Users\Entities\User;
use App\Accounts\ResolveUserAccountFromRequest;

class ResolveUserAccountFromRequestTest extends TestCase
{
    public function testItResolvesTheUserAccountFromTheRequest()
    {
        $user = factory(User::class)->create();

        $this->actingAsUser($user);

        $this->assertTrue($user->account->is(app(ResolveUserAccountFromRequest::class)->get()));
    }
}
