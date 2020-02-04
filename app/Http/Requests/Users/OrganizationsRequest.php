<?php

namespace App\Http\Requests\Users;

use Illuminate\Validation\Rule;
use App\Http\Requests\UniqueRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class OrganizationsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', $this->nameValidationRule()],
            'address' => 'sometimes',
            'unique_name' => 'required',
        ];
    }

    /**
     * The name validation rule
     * @return \Illuminate\Validation\Rules\Unique
     */
    protected function nameValidationRule()
    {
        return UniqueRule::for('organizations')
            ->ignoreRoute('organizations')
            ->where('user_id', '!=', Auth::id());
    }
}
