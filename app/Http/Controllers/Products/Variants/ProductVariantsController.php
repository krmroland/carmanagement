<?php

namespace App\Http\Controllers\Products\Variants;

use Illuminate\Http\Request;
use App\Products\Entities\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class ProductVariantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $this->authorize('accountAccess', $product);

        return $product->variants()->paginateUsingCurrentRequest();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('accountAccess', $product);

        $variant = $product->variants()->create($request->validate(['identifier' => 'required']));

        return Response::json([
            'message' => 'Variant was added successfully',
            'variant' => $variant,
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
