<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Accounts\TenantsController;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\Products\Variants\ProductVariantsController;

Route::middleware('auth:sanctum')->get('auth/user', function (Request $request) {
    return response()->json($request->user());
});

Route::middleware(['auth:sanctum'])
    ->prefix('v1')
    ->group(base_path('routes/v1.php'));
