<?php

namespace App\Products\Models;

use App\Models\BaseModel;
use App\Models\BasePivot;
use App\Users\Models\User;
use Illuminate\Validation\Rule;
use App\Products\Variants\UserActions;

class ProductVariant extends BaseModel
{
    /**
     * The casts array
     * @var array
     */
    protected $casts = ['details' => 'json'];

    /**
     * The touches array
     * @var array
     */
    protected $touches = ['product'];

    /**
     * Hooks into the eloquent booting process
     */
    public static function boot()
    {
        parent::boot();
        // let's try to validate the identifier here
        static::saving(function ($model) {
            return $model->validateUniqueIdentifier();
        });
    }

    /**
     * Validates the unique indetifier before saving
     * @throws Validation Exception
     */
    public function validateUniqueIdentifier()
    {
        if (blank($this->identifier)) {
            return;
        }

        return validator()->validate($this->only('identifier'), [
            'identifier' => Rule::unique('product_variants')
                ->ignore($this->id)
                ->where(function ($query) {
                    $query->where($this->only(['product_id']));
                }),
        ]);
    }

    /**
     * The product variant users
     * @return HasMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'product_variant_users')
            ->withTimestamps()
            ->withPivot(['started_at', 'ended_at', 'accepted_at', 'due_amount', 'paid_amount'])
            ->as('tenancy')
            ->using(BasePivot::class);
    }

    /**
     * The product relationship
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The user actions
     * @return \App\Products\Variants\UserActions
     */
    public function userActions()
    {
        return new UserActions($this);
    }
}
