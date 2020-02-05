<?php

namespace App\Products\Variants;

use App\Users\Models\User;

class UserActions extends VariantActions
{
    /**
     * Returns the current user
     * @return \App\Users\Models\User|null
     */
    public function current()
    {
        return $this->variant->currentUser;
    }

    /**
     * Adds a user to the current product variant
     */
    public function add(User $user)
    {
        if ($this->has($user)) {
            return $this->raiseError('User already belongs to the product');
        }

        // we shouldn't allow users that own the parent product

        if ($user->directlyOwnsProductVariant($this->variant)) {
            return $this->raiseError('You cannot add product owner to a variant');
        }

        $this->variant->users()->attach($user);

        // send an invitation email // notification
    }

    /**
     * Determines if the current variant has a given user
     * @return boolean
     */
    public function has(User $user)
    {
        return $this->variant
            ->users()
            ->wherePivot('user_id', $user->id)
            ->exists();
    }
}
