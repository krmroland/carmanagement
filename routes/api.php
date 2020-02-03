<?php

use Illuminate\Http\Request;

Route::middleware('auth:airlock')
    ->prefix('v1')
    ->group(function () {
        Route::namespace('Users')->group(base_path('routes/users.php'));
    });
