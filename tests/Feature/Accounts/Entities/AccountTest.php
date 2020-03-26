<?php

namespace Tests\Feature\Accounts\Entities;

use Tests\TestCase;
use App\Users\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatingAUserCreatesAnAccount()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('accounts', [
            'owner_id' => $user->id,
            'owner_type' => $user->getMorphClass(),
        ]);
    }

    public function testAllowsUserReturnsTrueForAccountOwners()
    {
        $user = factory(User::class)->create();

        $account = $user->account;

        $this->assertTrue($account->allowsUser($user));
    }

    public function testAllowsUserReturnsFalseForOtherUsers()
    {
        $user = factory(User::class)->create();

        $this->assertFalse($user->account->allowsUser(factory(User::class)->create()));
    }
}
