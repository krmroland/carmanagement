<?php

namespace App\Http\Requests\Products;

use Illuminate\Validation\Rule;
use App\Products\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'currency' => 'required',
            'details' => 'array',
            'total_cost' => 'numeric',
            'type' => ['required', Rule::in(Product::TYPES)],
        ];
    }
}
