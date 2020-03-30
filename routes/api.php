<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('auth/user', function (Request $request) {
    return response()->json($request->user());
});

Route::middleware(['auth:sanctum'])
    ->prefix('v1')
    ->group(base_path('routes/v1.php'));
