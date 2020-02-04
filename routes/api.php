<?php

use Illuminate\Http\Request;

Route::middleware('auth:airlock')
    ->prefix('v1')
    ->group(base_path('routes/v1/all.php'));
