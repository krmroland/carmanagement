<?php

namespace App\Accounts\Entities;

use App\Models\BaseModel;
use App\Users\Entities\User;
use App\Accounts\Models\Tenant;
use App\Accounts\Models\Product;
use App\Accounts\Models\Illuminate;

class Account extends BaseModel
{
    /**
     * The products relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * A user can have many tenants
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    /**
     * The account owner
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo('owner');
    }

    /**
     * Determines if the current account allows a given user
     * @return User
     */
    public function allowsUser(User $user)
    {
        return optional($this->owner)->is($user);
    }
}
