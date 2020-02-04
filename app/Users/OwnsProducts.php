<?php

namespace App\Users;

use Illuminate\Support\Arr;
use App\Products\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Users\Models\OwnerUniqueName;

trait OwnsProducts
{
    /**
     * Save the model to the database.
     *
     * @return bool
     */
    public function save(array $options = [])
    {
        // we will have to extract the unique name from the attributes if it exist
        if (!array_key_exists('unique_name', $this->attributes)) {
            return parent::save($options);
        }

        return DB::transaction(function () use ($options) {
            $uniqueName = Arr::pull($this->attributes, 'unique_name');

            return tap(parent::save($options), function ($saved) use ($uniqueName) {
                if ($saved) {
                    $this->setUniqueName($uniqueName);
                }
            });
        });
    }

    /**
     * The unique name relationship
     * @return MoprhOne
     */
    public function uniqueName()
    {
        return $this->morphOne(OwnerUniqueName::class, 'owner');
    }

    /**
     * Sets a given unique name
     */
    public function setUniqueName($value)
    {
        $this->uniqueName()
            ->firstOrNew([])
            ->updateValue($value);

        return $this;
    }

    /**
     * Gets the unique name of the given model
     * @return string|null
     */
    public function getUniqueName()
    {
        return optional($this->uniqueName)->value;
    }

    /**
     * The products relationship
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function products()
    {
        return $this->morphMany(Product::class, 'owner');
    }
}
