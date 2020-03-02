<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory;

abstract class ApiFormRequest extends FormRequest
{
    /**
     * The application validator
     * @return \Illuminate\Contracts\Validation\Factory
     */
    public function validator(Factory $factory)
    {
        return $factory->make(
            $this->validationData(),
            $this->container->call([$this, 'getPreparedRules']),
            $this->messages(),
            $this->attributes()
        );
    }

    /**
     * Gets the prepared rules
     * @return array
     */
    public function getPreparedRules()
    {
        return $this->method() === 'PATCH' ? $this->optionalRules() : $this->rules();
    }

    /**
     * Makes rules optional
     * @return array
     */
    protected function optionalRules()
    {
        return array_map(function ($constraits) {
            return is_array($constraits)
                ? array_merge(['sometimes'], $constraits)
                : 'sometimes|' . $constraits;
        }, $this->rules());
    }
}
