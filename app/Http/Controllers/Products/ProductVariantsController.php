<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Products\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

/**
 * @todo add authorization policies
 */
class ProductVariantsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $variant = with($product->variants())->create(
            $request->validate(['identifier' => 'required', 'details' => 'array'])
        );

        return Response::json([
            'message' => 'Variant was added successfully',
            'variant' => $variant,
        ])->setStatusCode(201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, $variant)
    {
        $variant = with($product->variants()->findOrFail($variant))->update(
            $request->validate(['identifier' => 'required', 'details' => 'array'])
        );

        return response()->json([
            'message' => 'Variant was updated successfully',
            'variant' => $variant,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $variant)
    {
        return response()->json([
            'message' => 'Operation was successful',
            'deleted' => with($product->variants()->findOrFail($variant))->delete(),
        ]);
    }
}
