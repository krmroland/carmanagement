<?php

namespace App\Products\Models;

use App\Models\BaseModel;
use Illuminate\Support\Arr;
use App\Currencies\HasCurrency;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Product extends BaseModel
{
    use HasCurrency;

    /**
     * The available product types
     */
    public const TYPES = ['car', 'house'];

    /**
     * The casts array
     * @var array
     */
    protected $casts = ['details' => 'json', 'total_cost' => 'decimal:8,2'];

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

            return tap(parent::save($options), function ($saved) use ($fields) {
                if (count(Arr::wrap($fields)) > 0 && $saved) {
                    return $this->variants()->create($fields);
                }
            });
        });
    }
}
