<?php

namespace Tests\Feature\Tenants\Controllers;

use Tests\TestCase;
use App\Users\Entities\User;
use App\Tenants\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItCreatesANewTenant()
    {
        $user = factory(User::class)->create();

        $data = factory(Tenant::class)->raw();

        $this->actingAs($user)
            ->postJson('/api/v1/tenants', $data)
            ->assertCreated()
            ->assertJsonPath('tenant.user_id', $user->id);
    }

    public function testItCannotDuplicateTheSamePhoneNumberForSameUserId()
    {
        $user = factory(User::class)->create();

        $attributes = ['phone_number' => '+25670000000', 'user_id' => $user];

        factory(Tenant::class)->create($attributes);

        $data = factory(Tenant::class)->raw($attributes);

        $this->actingAs($user)
            ->postJson('/api/v1/tenants', $data)
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'phone_number' => 'The phone number has already been taken.',
            ]);
    }

    public function testItLoadsTenantsForAGivenUser()
    {
        $user = factory(User::class)->create();

        factory(Tenant::class, 3)->create(['user_id' => $user]);

        factory(Tenant::class, 2)->create();

        $this->actingAs($user)
            ->getJson('/api/v1/tenants?per_page=100')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function testPatchUpdatesOnlyEmail()
    {
        $user = factory(User::class)->create();

        $tenant = factory(Tenant::class)->create(['user_id' => $user]);

        $this->actingAs($user)
            ->patchJson("/api/v1/tenants/{$tenant->id}", ['email' => 'updated@email.com'])
            ->assertOk();

        $this->assertEquals($tenant->fresh()->email, 'updated@email.com');
    }

    public function testItSoftDeletesAtenant()
    {
        $user = factory(User::class)->create();

        $tenant = factory(Tenant::class)->create(['user_id' => $user]);

        $this->actingAs($user)
            ->deleteJson("/api/v1/tenants/{$tenant->id}")
            ->assertOk();

        $this->assertSoftDeleted('tenants', $tenant->only('id'));
    }

    public function testDifferentUsersCannotDeleteTenants()
    {
        $user = factory(User::class)->create();

        $tenant = factory(Tenant::class)->create(['user_id' => factory(User::class)]);

        $this->actingAs($user)
            ->deleteJson("/api/v1/tenants/{$tenant->id}")
            ->assertForbidden();
    }
}
