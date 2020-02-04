<?php

Route::apiResource('@{productOwner}/products', ProductsController::class);

Route::apiResource('products.variants', ProductVariantsController::class)->only([
    'store',
    'update',
    'destroy',
]);
