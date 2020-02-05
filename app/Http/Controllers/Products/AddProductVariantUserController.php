<?php

namespace App\Http\Controllers\Products;

use App\Users\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products\Models\ProductVariant;

class AddProductVariantUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, ProductVariant $productVariant)
    {
        $this->authorize('write', $productVariant->product);

        $request->validate(['user_id' => 'required|exists:users,id']);

        $productVariant->userActions()->add(User::findOrFail($request->user_id));

        return response()->json(['message' => 'User was added successfully'], 201);
    }
}
