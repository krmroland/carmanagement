<?php

namespace Tests\Feature\Users\Auth;

use Tests\TestCase;
use App\Users\Models\User;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssociatableGateTest extends TestCase
{
    use RefreshDatabase;

    public function testGateAllowReturnsNullForNoUsers()
    {
        $organization = factory(Organization::class)->create();

        $this->assertFalse($organization->gate(null)->allows());
    }

    public function testGateAllowsOragnizationOwners()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create(['user_id' => $user]);

        $this->assertTrue($organization->gate($user)->allows('every-action'));
    }

    public function testGateAllowsOragnizationMembers()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $this->assertTrue($organization->gate($user)->allows());
    }

    public function testGateDeniesMemebersWithNoSpecficPermission()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $this->assertFalse($organization->gate($user)->allows('specific-permission'));
    }

    public function testGateAllowsMemebersWithSpecficPermission()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $organization->gate($user)->updateAbilities('specific-permission');

        $this->assertTrue($organization->gate($user)->allows('specific-permission'));
    }

    public function testAddMembersAddsMemberWithAbilities()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user, ['permission-one']);

        $this->assertEquals($organization->findUser($user)->pivot->abilities, ['permission-one']);
    }
}
