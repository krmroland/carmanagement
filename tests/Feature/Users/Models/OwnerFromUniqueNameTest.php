<?php

namespace Tests\Feature\Users\Models;

use Tests\TestCase;
use App\Users\Models\User;
use App\Users\Models\Organization;
use App\Users\Models\OwnerFromUniqueName;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OwnerFromUniqueNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_sets_a_gicen_users_unique_name()
    {
        $user = factory(User::class)->create();

        $user->setUniqueName('me');

        $this->assertEquals($user->uniqueName->value, 'me');
    }

    public function test_updated_doesnt_throw_an_exception_for_the_same_owner_with_same_unique_name()
    {
        $user = factory(User::class)->create();

        $user->setUniqueName('me');

        $user->setUniqueName('me');

        $this->assertEquals($user->uniqueName->value, 'me');
    }

    public function test_user_cannot_user_a_name_that_has_been_used_by_an_organization()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();
        $user->setUniqueName('me');
        $this->expectException(ValidationException::class);
        $organization->setUniqueName('me');
    }

    public function test_it_resolves_a_user_from_a_route_user_name()
    {
        $user = factory(User::class)
            ->create()
            ->setUniqueName('me');

        $this->assertTrue($user->is((new OwnerFromUniqueName())->resolveRouteBinding('me')));
    }

    public function test_it_resolve_route_binding_fails_if_username_doesnot_exist()
    {
        $this->expectException(ModelNotFoundException::class);

        (new OwnerFromUniqueName())->resolveRouteBinding('me');
    }
}
