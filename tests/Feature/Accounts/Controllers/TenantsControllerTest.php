<?php

namespace Tests\Feature\Accounts\Controllers;

use Tests\TestCase;
use App\Users\Entities\User;
use App\Tenants\Entities\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItGetsAllAccountTenants()
    {
        $user = factory(User::class)->create();

        factory(Tenant::class, 3)->create(['account_id' => $user->account]);

        $this->actingAsUser($user)
            ->getJson('/api/v1/tenants')
            ->dump()
            ->assertOk();
    }

    public function test_it_creates_a_new_tenant()
    {
        $data = factory(Tenant::class)->raw();

        $this->actingAsUser()
            ->postJson('/api/v1/tenants', $data)
            ->assertCreated();
    }
}
