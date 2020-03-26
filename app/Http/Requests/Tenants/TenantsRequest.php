<?php

namespace App\Http\Requests\Tenants;

use App\Http\Requests\UniqueRule;
use App\Http\Requests\ApiFormRequest;

class TenantsRequest extends ApiFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['nullable', 'email', $this->uniqueRule()],
            'phone_number' => ['required', $this->uniqueRule()],
            'first_name' => ['required'],
            'last_name' => ['required'],
        ];
    }

    /**
     * Unique rule
     * @return \Illuminate\Validation\Rules\Unique
     */
    protected function uniqueRule()
    {
        return UniqueRule::for('tenants')
            ->ignoreRoute('tenant')
            ->forAuthenticatedUser();
    }
}
