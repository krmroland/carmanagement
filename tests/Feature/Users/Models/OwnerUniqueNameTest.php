<?php

namespace Tests\Feature\Users\Models;

use Tests\TestCase;
use App\Users\Models\User;
use App\Users\Models\Organization;
use App\Users\Models\OwnerUniqueName;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OwnerUniqueNameTest extends TestCase
{
    use RefreshDatabase;

    public function testItSetsAGicenUsersUniqueName()
    {
        $user = factory(User::class)->create();

        $user->setUniqueName('me');

        $this->assertEquals($user->uniqueName->value, 'me');
    }

    public function testUpdatedDoesntThrowAnExceptionForTheSameOwnerWithSameUniqueName()
    {
        $user = factory(User::class)->create();

        $user->setUniqueName('me');

        $user->setUniqueName('me');

        $this->assertEquals($user->uniqueName->value, 'me');
    }

    public function testUserCannotUserANameThatHasBeenUsedByAnOrganization()
    {
        $user = factory(User::class)->create();

        $organization = factory(Organization::class)->create();
        $user->setUniqueName('me');
        $this->expectException(ValidationException::class);
        $organization->setUniqueName('me');
    }

    public function testItResolvesAUserFromARouteUserName()
    {
        $user = factory(User::class)
            ->create()
            ->setUniqueName('me');

        $this->assertTrue($user->is((new OwnerUniqueName())->resolveRouteBinding('me')));
    }

    public function testItResolveRouteBindingFailsIfUsernameDoesnotExist()
    {
        $this->expectException(ModelNotFoundException::class);

        (new OwnerUniqueName())->resolveRouteBinding('me');
    }
}
