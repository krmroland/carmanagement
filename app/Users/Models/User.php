<?php

namespace App\Users\Models;

use App\Models\Helpers;
use Illuminate\Support\Arr;
use App\Contracts\ProductOwner;
use App\Products\Models\Product;
use Laravel\Airlock\HasApiTokens;
use App\Products\Models\ProductVariant;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements ProductOwner
{
    use Notifiable, HasApiTokens, Helpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => true,
    ];

    /**
     * Determine if the current user is an administrator
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Determines if user directly owns product variant
     * @return boolean
     */
    public function directlyOwnsProductVariant(ProductVariant $variant)
    {
        return $this->directlyOwnsProduct($variant->product);
    }

    /**
     * Determines if the current user directly owns a given product
     * @return boolean
     */
    public function directlyOwnsProduct(Product $product)
    {
        $cacheKey = vsprintf('%s.%s', [
            $product->updatedAtCacheKey('product'),
            $this->updatedAtCacheKey('user'),
        ]);

        return cache()->rememberForever($cacheKey, function () use ($product) {
            $owner = Arr::get($product->loadMissing('owner'), 'owner');
            return transform($owner, function ($owner) {
                return $owner && $owner instanceof self && $owner->id === (int) $this->id;
            });
        });
    }

    /**
     * The products relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
