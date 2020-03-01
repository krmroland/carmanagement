<?php

namespace App\Http\Requests\Products;

use Illuminate\Validation\Rule;
use App\Products\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|string',
            'currency' => 'sometimes',
            'details' => 'array|sometimes',
            'total_cost' => 'numeric|sometimes',
            'type' => ['sometimes', Rule::in(Product::TYPES)],
        ];
    }
}
