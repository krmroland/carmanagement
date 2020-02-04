<?php

namespace App\Http\Requests\Products;

class ProductCreateRequest extends ProductWriteRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            'variant_fields' => 'required|array',
            'variant_fields.identifier' => 'required',
        ]);
    }
}
