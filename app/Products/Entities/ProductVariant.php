<?php

namespace App\Products\Entities;

use App\Entities\BasePivot;
use Illuminate\Validation\Rule;
use App\Tenants\Entities\Tenant;
use App\Accounts\RecordsAccountDataHistoryModel;

class ProductVariant extends RecordsAccountDataHistoryModel
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
    public static function booted()
    {
        // Every variant should have a unique identifier from other variants that belong to the
        // same product
        static::saving(fn($model) => $model->validateUniqueIdentifier());
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
     * The product variant tenants
     * @return HasMany
     */
    public function tenants()
    {
        return $this->belongsToMany(Tenant::class, 'product_tenants')
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
     * Gets the account id
     * @return int
     */
    public function getAccountId()
    {
        return optional($this->product)->account_id;
    }
}
