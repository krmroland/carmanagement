<?php

namespace Tests\Feature\Users\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationUsersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_all_organization_memebers()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create(['user_id' => $user]);

        $organization->members()->attach(factory(User::class, 2)->create());

        $this->actingAsUser($user)
            ->getJson("/api/v1/organizations/$organization->id/users")
            ->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function test_it_adds_a_new_memeber_to_an_organization()
    {
        $organization = factory(Organization::class)->create();

        $member = factory(User::class)->create();

        $this->actingAsUser($organization->owner)
            ->postJson("/api/v1/organizations/$organization->id/users", ['user_id' => $member->id])
            ->assertOk();

        $this->assertTrue($organization->hasMember($member));
    }

    public function test_it_removes_an_existing_memeber_from_an_organization()
    {
        $organization = factory(Organization::class)->create();

        $member = factory(User::class)->create();

        $organization->addMember($member);

        $this->actingAsUser($organization->owner)
            ->deleteJson("/api/v1/organizations/$organization->id/users/$member->id")
            ->assertOk();

        $this->assertFalse($organization->fresh()->hasMember($member));
    }

    public function test_remove_returns_404_if_user_is_not_part_of_the_organization()
    {
        $organization = factory(Organization::class)->create();

        $member = factory(User::class)->create();

        $this->actingAsUser($organization->owner)
            ->deleteJson("/api/v1/organizations/$organization->id/users/$member->id")
            ->assertNotFound();
    }

    public function test_it_updates_organization_members_abilities()
    {
        $organization = factory(Organization::class)->create();

        $member = factory(User::class)->create();

        $organization->addMember($member);

        $abilities = ['one', 'two', 'three'];

        $this->actingAsUser($organization->owner)
            ->putJson(
                "/api/v1/organizations/$organization->id/users/$member->id",
                compact('abilities')
            )

            ->assertOk();

        $this->assertEquals($organization->findUser($member)->pivot->abilities, $abilities);
    }
}
