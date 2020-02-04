<?php

namespace App\Policies;

use App\Users\Models\User;
use App\Products\Models\Product;
use App\Users\Models\Organization;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the product.
     *
     * @param  \App\Users\Models\Users\Models\User  $user
     */
    public function write(User $user, Product $product)
    {
        $owner = $product->owner;

        if (is_null($owner)) {
            return false;
        }

        return $owner instanceof Organization
            ? $owner->gate($user)->allows('products.write')
            : $user->id === (int) $product->owner_id;
    }
}
