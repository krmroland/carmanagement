<?php

namespace App\Products\Entities;

use App\Casts\Currency;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Accounts\RecordsAccountDataHistoryModel;

class Product extends RecordsAccountDataHistoryModel
{
    /**
     * The available product offerings
     */
    public const OFFERINGS = ['car', 'house'];

    /**
     * The casts array
     * @var array
     */
    protected $casts = [
        'details' => 'json',
        'total_cost' => 'decimal:2',
        'stats' => 'json',
        'currency' => Currency::class,
    ];

    /**
     * A product has many variants
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Save the model to the database.
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        return DB::transaction(function () use ($options) {
            // if we have variant fields, we will just extract them

            if ($this->exists) {
                return parent::save($options);
            }

            $fields = Arr::pull($this->attributes, 'variant_fields');

            $saved = parent::save($options);

            if ($saved && count(Arr::wrap($fields)) > 0) {
                $this->variants()->create($fields);
            }

            return $saved;
        });
    }
}
