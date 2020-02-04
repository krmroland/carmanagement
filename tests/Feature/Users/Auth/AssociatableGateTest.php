<?php

namespace Tests\Feature\Users\Auth;

use Tests\TestCase;
use App\Users\Models\User;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssociatableGateTest extends TestCase
{
    use RefreshDatabase;

    public function test_gate_allow_returns_null_for_no_users()
    {
        $organization = factory(Organization::class)->create();

        $this->assertFalse($organization->gate(null)->allows());
    }

    public function test_gate_allows_oragnization_owners()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create(['user_id' => $user]);

        $this->assertTrue($organization->gate($user)->allows('every-action'));
    }

    public function test_gate_allows_oragnization_members()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $this->assertTrue($organization->gate($user)->allows());
    }

    public function test_gate_denies_memebers_with_no_specfic_permission()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $this->assertFalse($organization->gate($user)->allows('specific-permission'));
    }

    public function test_gate_allows_memebers_with_specfic_permission()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $organization->gate($user)->updateAbilities('specific-permission');

        $this->assertTrue($organization->gate($user)->allows('specific-permission'));
    }

    public function test_add_members_adds_member_with_abilities()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user, ['permission-one']);

        $this->assertEquals($organization->findUser($user)->pivot->abilities, ['permission-one']);
    }
}
