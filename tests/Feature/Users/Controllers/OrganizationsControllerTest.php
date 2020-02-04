<?php

namespace Tests\Feature\Users\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItListsTheAvailableOrganizations()
    {
        factory(Organization::class, 3)->create();

        $this->actingAsUserWithPermission(['organizations.view'])
            ->getJson('/api/v1/organizations')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function testItCreatesANewOrganization()
    {
        $data = factory(Organization::class)->make();

        $user = factory(User::class)->create();

        $this->actingAsUser($user)
            ->postJson('/api/v1/organizations', $data->toArray())
            ->assertCreated();
    }

    public function testCreatingOrganizationUsesIdOfAuthenticatedUser()
    {
        $data = factory(Organization::class)->make();

        $user = factory(User::class)->create();

        $this->actingAsUser($user)
            ->postJson('/api/v1/organizations', $data->toArray())
            ->assertCreated()
            ->assertJsonPath('organization.user_id', $user->id);
    }

    public function testUserCannotCreateOrganizationWithSameName()
    {
        $data = factory(Organization::class)->make();

        $user = factory(User::class)->create();

        $this->actingAsUser($user)
            ->postJson('/api/v1/organizations', $data->toArray())
            ->assertCreated()
            ->assertJsonPath('organization.user_id', $user->id);
    }

    public function testItShowsTheDetailsOfAnOrganization()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $this->actingAsUser($user)
            ->getJson("/api/v1/organizations/{$organization->id}")
            ->assertOk();
    }
}
