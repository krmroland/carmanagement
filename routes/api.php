<?php

Route::middleware('auth:airlock')
    ->prefix('v1')
    ->group(base_path('routes/v1/all.php'));

Route::post('v1/auth/token', Auth\IssueOAuthTokensController::class);
