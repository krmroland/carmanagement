<?php

namespace App\Http\Requests\Products;

use App\Users\Models\Organization;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseProductRequest extends FormRequest
{
    /**
     * The permission name to use for the request
     * @return string
     */
    abstract public function permissionName();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $owner = $this->route('productOwner');

        if ($owner instanceof Organization) {
            return $owner->gate()->authorize($this->permissionName());
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
