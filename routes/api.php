<?php

use App\Http\Controllers\Auth\APILoginController;

Route::middleware('auth:airlock')
    ->prefix('v1')
    ->group(base_path('routes/v1/all.php'));

Route::post('v1/auth/register', 'Auth\UserRegistrationController@register');
Route::post('v1/auth/token', Auth\IssueOAuthTokensController::class);

Route::post('v1/auth/login', [APILoginController::class, 'login'])->middleware(['web']);
