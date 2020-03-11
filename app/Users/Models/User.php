<?php

namespace App\Users\Models;

use App\Models\Helpers;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Accounts\HasAccount;
use App\Tenants\Models\Tenant;
use App\Contracts\ProductOwner;
use App\Products\Models\Product;
use Laravel\Airlock\HasApiTokens;
use Laravel\Airlock\NewAccessToken;
use App\Products\Models\ProductVariant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Organizations\Entities\Organization;
use App\Organizations\Entities\OrganizationUser;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements ProductOwner
{
    use Notifiable, HasApiTokens, Helpers, HasAccount;

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
     * Determines if user directly owns product variant
     * @return boolean
     */
    public function directlyOwnsProductVariant(ProductVariant $variant)
    {
        return $this->directlyOwnsProduct($variant->product);
    }

    /**
     * Determine if the current user is an administrator
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

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
     * Determines if the current user owns a model
     * @param  Model|int $model
     * @param  string $key
     * @return boolean
     */
    public function ownsEntity($model, $key = 'user_id')
    {
        $id = $model instanceof Model ? $model->getAttribute($key) : $model;

        return $this->id === (int) $id;
    }

    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  array  $abilities
     * @return \Laravel\Airlock\NewAccessToken
     */
    public function createToken($data, array $abilities = ['*'])
    {
        $token = $this->tokens()
            ->make([
                'token' => hash('sha256', $plainTextToken = Str::random(80)),
                'abilities' => $abilities,
            ])
            ->forceFill($data);

        $token->save();

        return new NewAccessToken($token, $plainTextToken);
    }
    /**
     * A user can belong to many organizations
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_users')
            ->using(OrganizationUser::class)
            ->withTimestamps();
    }
}
