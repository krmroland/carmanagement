<?php

namespace App\Http\Controllers\Products;

use App\Users\Models\User;
use Illuminate\Http\Request;
use App\Contracts\ProductOwner;
use App\Http\Controllers\Controller;
use App\Users\Models\OwnerUniqueName;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Products\ProductReadRequest;
use App\Http\Requests\Products\ProductWriteRequest;
use App\Http\Requests\Products\ProductCreateRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductReadRequest $request, ProductOwner $productOwner)
    {
        return $productOwner->products()->paginateByRequest();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request, ProductOwner $productOwner)
    {
        $product = $productOwner->products()->create($request->validated());

        return Response::json(
            ['message' => 'Product was created successfully', 'product' => $product],
            201
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductReadRequest $request, ProductOwner $productOwner, $id)
    {
        return $productOwner->products()->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductWriteRequest $request, ProductOwner $productOwner, $id)
    {
        return $productOwner
            ->products()
            ->findOrFail($id)
            ->persistAttributes($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
