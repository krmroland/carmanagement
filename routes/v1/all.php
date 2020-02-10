<?php

Route::namespace('Users')->group(base_path('routes/v1/users.php'));
Route::namespace('Products')->group(base_path('routes/v1/products.php'));
Route::get('user', function (\Illuminate\Http\Request $request) {
    return $request->user();
});
