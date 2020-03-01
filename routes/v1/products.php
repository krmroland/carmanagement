<?php

Route::apiResource('products', ProductsController::class)->except(['index']);

Route::apiResource('products.variants', ProductVariantsController::class)->only([
    'store',
    'update',
    'destroy',
]);

Route::post('productVariants/{productVariant}/users', AddProductVariantUserController::class);
