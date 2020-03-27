<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Factory;

abstract class ApiFormRequest extends FormRequest
{
    /**
     * Determines if we should include the account id in the validated results
     * @var string|null
     */
    protected $includedAccountIdFieldName = null;

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
     * Includes the account id into the current request
     * @return $this
     */
    public function withAuthAccountId($key = 'account_id')
    {
        $this->merge([$key => optional($this->userAccount())->getKey()]);

        $this->includedAccountIdFieldName = $key;

        return $this;
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated()
    {
        $results = parent::validated();

        if ($this->includedAccountIdFieldName) {
            $results += $this->only($this->includeAccountFieldName);
        }

        return $results;
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
