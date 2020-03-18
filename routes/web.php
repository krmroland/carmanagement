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

// Route::get('/', function () {
//     // Establish username and password for bucket-access
//     $authenticator = new \Couchbase\PasswordAuthenticator();
//     $authenticator->username('Administrator')->password('havatech@123');
//     // Connect to Couchbase Server - using address of a KV (data) node
//     $cluster = new CouchbaseCluster('couchbase://127.0.0.1');

//     // Authenticate, then open bucket
//     $cluster->authenticate($authenticator);

//     // $bucket = $cluster->openBucket('test');
//     //

//     $bucket = $cluster->openBucket('test');

//     dd($bucket);
// });

Route::prefix('auth')
    ->get('/{any}', HomeController::class)
    ->middleware('guest');

Auth::routes();

Route::get('/{any}', HomeController::class)
    ->where('any', '.*')
    ->middleware(['auth']);
