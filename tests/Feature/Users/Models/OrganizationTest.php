<?php

namespace Tests\Feature\Users\Models;

use Tests\TestCase;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    public function testItSlugsTheUniqueNameWhenAnOrganizationIsCreated()
    {
        $organization = factory(Organization::class)->create(['unique_name' => 'Unique Name']);

        $this->assertEquals($organization->uniqueName->value, 'unique-name');
    }
}
