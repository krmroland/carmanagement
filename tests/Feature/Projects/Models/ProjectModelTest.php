<?php

namespace Tests\Feature\Projects\Models;

use Tests\TestCase;
use App\Users\Models\User;
use App\Projects\Models\Project;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_fails_if_identification_exists_already()
    {
        $user = factory(User::class)->create();

        $data = factory(Project::class)->raw(['identifier' => '12345']);

        $user->projects()->create($data);

        // try to create a gain
        $this->expectException(ValidationException::class);

        $user->projects()->create($data);
    }
    public function test_same_identifier_doesnt_fail_on_updating_for_same_user()
    {
        $user = factory(User::class)->create();

        $data = factory(Project::class)->raw(['identifier' => '12345']);

        $project = $user->projects()->create($data);

        $project->update(['identifier' => '12345']);

        $this->assertEquals($project->fresh()->identifier, '12345');
    }
    public function test_different_users_can_use_the_same_indentifier()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();

        $data = factory(Project::class)->raw(['identifier' => '12']);

        $user->projects()->create($data);

        $project = $organization->projects()->create($data);

        $this->assertEquals($project->identifier, '12');
    }
}
