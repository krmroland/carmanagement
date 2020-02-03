<?php

namespace Tests\Feature\Users\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_the_available_organizations()
    {
        factory(Organization::class, 3)->create();

        $this->actingAsUserWithPermission(['organizations.view'])
            ->getJson('/api/v1/organizations')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_it_creates_a_new_organization()
    {
        $data = factory(Organization::class)->make();

        $user = factory(User::class)->create();

        $this->actingAsUser($user)
            ->postJson('/api/v1/organizations', $data->toArray())
            ->assertCreated();
    }

    public function test_creating_organization_uses_id_of_authenticated_user()
    {
        $data = factory(Organization::class)->make();

        $user = factory(User::class)->create();

        $this->actingAsUser($user)
            ->postJson('/api/v1/organizations', $data->toArray())
            ->assertCreated()
            ->assertJsonPath('organization.user_id', $user->id);
    }

    public function test_user_cannot_create_organization_with_same_name()
    {
        $data = factory(Organization::class)->make();

        $user = factory(User::class)->create();

        $this->actingAsUser($user)
            ->postJson('/api/v1/organizations', $data->toArray())
            ->assertCreated()
            ->assertJsonPath('organization.user_id', $user->id);
    }

    public function test_it_shows_the_details_of_an_organization()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $this->actingAsUser($user)
            ->getJson("/api/v1/organizations/$organization->id")
            ->assertOk();
    }
}
