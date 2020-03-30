<?php

use App\Http\Controllers\Accounts\TenantsController;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\Products\Variants\ProductVariantsController;

Route::apiResource('tenants', TenantsController::class);
Route::apiResource('products', ProductsController::class);
Route::apiResource('products.variants', ProductVariantsController::class);
