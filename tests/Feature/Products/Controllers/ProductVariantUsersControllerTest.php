<?php

namespace Tests\Feature\Products\Controllers;

use Tests\TestCase;
use App\Users\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariantUsersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testItListsAllHistoricalUsersUnderAProductVariant()
    {
        $user = factory(User::class)->create();

        $variant = $this->createProductVariantForUser($user);

        $tenant = factory(User::class)->create();

        $this->actingAs($user)
            ->postJson("api/v1/productVariants/{$variant->id}/users", ['user_id' => $tenant->id])
            ->assertCreated();

        $this->assertTrue($variant->userActions()->has($tenant));
    }
}
