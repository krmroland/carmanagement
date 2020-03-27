<?php

namespace App\Http\Requests\Products;

use Illuminate\Validation\Rule;
use App\Products\Entities\Product;
use App\Http\Requests\ApiFormRequest;

class ProductRequest extends ApiFormRequest
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
