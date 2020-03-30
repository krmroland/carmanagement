<?php

namespace App\Casts;

use Illuminate\Validation\Rule;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Currency implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return config()->get("currencies.${value}", $value);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return array
     */
    public function set($model, string $key, $value, array $attributes)
    {
        validator([$key => $value], [$key => $this->validationRules()])->validate();

        return $value;
    }

    /**
     * The currency validation rules
     * @return array
     */
    protected function validationRules()
    {
        return ['sometimes', 'string', Rule::in(array_keys(config()->get('currencies')))];
    }
}
