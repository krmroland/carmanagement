<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', HomeController::class)->name('home');

Route::prefix('auth')
    ->get('/{any}', HomeController::class)
    ->middleware('guest');

Auth::routes();

Route::get('/{any}', HomeController::class)
    ->where('any', '.*')
    ->middleware(['auth']);
