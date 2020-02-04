<?php

namespace App\Products\Models;

use App\Models\BaseModel;
use Illuminate\Validation\Rule;

class ProductVariant extends BaseModel
{
    /**
     * The casts array
     * @var array
     */
    protected $casts = ['details' => 'json'];

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
}
