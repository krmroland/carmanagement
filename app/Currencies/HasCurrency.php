<?php

namespace App\Currencies;

use Illuminate\Validation\Rule;

trait HasCurrency
{
    /**
     * Sets the currency attributes
     * @param string $currency
     */
    public function setCurrencyAttribute($currency)
    {
        validator(compact('currency'), [
            'currency' => [
                'sometimes',
                'string',
                Rule::in(array_keys(config()->get('currencies'))),
            ],
        ])->validate();

        $this->attributes['currency'] = $currency;
    }

    /**
     * Gets the currency attribute
     * @param  string $code
     * @return array|string
     */
    public function getCurrencyAttribute($code)
    {
        return config()->get("currencies.${code}", $code);
    }
}
