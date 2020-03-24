<?php

use App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;

Route::middleware('guest')->post('auth/login', LoginController::class);
Route::middleware('guest')->post('auth/register', RegisterController::class);

Route::post('auth/logout', LogoutController::class);
