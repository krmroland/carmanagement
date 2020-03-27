<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('auth/user', function (Request $request) {
    return response()->json($request->user());
});

Route::middleware(['auth:sanctum'])
    ->prefix('v1')
    ->group(function () {
        Route::apiResource('tenants', \App\Http\Controllers\Accounts\TenantsController::class);
        Route::apiResource('products', App\Http\Controllers\Products\ProductsController::class);
    });
