<?php

namespace App\Users\Auth\Models;

use App\Models\BaseModel;
use App\Users\Models\User;
use App\Users\Auth\AssociatableGate;
use Illuminate\Support\Facades\Auth;
use App\Users\Models\UserAssociations;

abstract class Associatable extends BaseModel
{
    /**
     * The gate to this association
     * @return  \App\Users\Auth\AssociatableGate
     */
    public function gate(User $user = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        return new AssociatableGate($this, $user);
    }
    /**
     * Determines if this organization has a direct member
     * @param  User    $user
     * @return boolean
     */
    public function hasDirectMember(User $user)
    {
        return $this->members()
            ->wherePivot('user_id', $user->id)
            ->exists();
    }

    /**
     * Determines if a member is part of an orgganization
     * @param  User    $user
     * @return boolean
     */
    public function hasMember(User $user)
    {
        return $this->isOwnedByUser($user) || $this->hasDirectMember($user);
    }
    /**
     * Adds a given member to an organization
     * @param User $user
     * @return boolean
     */
    public function addMember(User $user)
    {
        if (!$this->isOwnedByUser($user)) {
            return (bool) $this->members()->attach($user);
        }
    }

    /**
     * Finds a given member in the current association
     * @return \App\Users\Models\User|null
     */
    public function lookupMember(User $user)
    {
        return $this->members()
            ->wherePivot('user_id', $user->id)
            ->firstOrFail();
    }
    /**
     * Ensures a given member exists
     * @param  User   $user
     * @return $this
     */
    public function ensureMemberExists(User $user)
    {
        $this->lookupMember($user);

        return $this;
    }

    /**
     * An organization has many members
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->morphToMany(User::class, 'associatable', 'associatable_users')
            ->withPivot(['role', 'abilities'])
            ->using(UserAssociations::class)
            ->withTimeStamps();
    }
}
