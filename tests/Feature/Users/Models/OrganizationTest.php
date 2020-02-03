<?php

namespace Tests\Feature\Users\Models;

use Tests\TestCase;
use App\Users\Models\Organization;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrganizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_slugs_the_unique_name_when_an_organization_is_created()
    {
        $organization = factory(Organization::class)->create(['unique_name' => 'Unique Name']);

        $this->assertEquals($organization->uniqueName->value, 'unique-name');
    }
}
