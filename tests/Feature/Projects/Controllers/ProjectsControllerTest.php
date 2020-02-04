<?php

namespace Tests\Feature\Projects\Controllers;

use Tests\TestCase;
use App\Users\Models\User;
use App\Projects\Models\Project;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test__users_can_create_a_personal_project()
    {
        $user = factory(User::class)->create();

        $data = factory(Project::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$user->getUniqueName()}/projects", $data)
            ->assertCreated();

        $this->assertDatabaseHas('projects', ['name' => $data['name']]);
    }

    public function test_a_organization_users_can_create_a_project_in_an_organization()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create(['user_id' => $user]);

        $data = factory(Project::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/projects", $data)
            ->assertCreated();
    }

    public function test_non_organization_users_cannot_create_organization_projects()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $data = factory(Project::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/projects", $data)
            ->assertForbidden();
    }
    public function test_organization_users_with_write_permissions_can_create_projects()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user, ['projects.write']);

        $data = factory(Project::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/projects", $data)
            ->assertCreated();
    }
    public function test_create_fails_for_organization_memebers_with_no_write_permission()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $organization->addMember($user);

        $data = factory(Project::class)->raw();

        $this->actingAs($user)
            ->postJson("api/v1/@{$organization->getUniqueName()}/projects", $data)
            ->assertForbidden();
    }

    public function test_it_loads_all_user_projects()
    {
        // two for some other users
        factory(Project::class, 2)->create();

        $user = factory(User::class)->create();

        factory(Project::class, 3)->create($user->getMorhpAttributes('owner'));

        $this->actingAs($user)
            ->getJson("api/v1/@{$user->getUniqueName()}/projects")
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }
}
