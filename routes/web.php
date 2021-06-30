<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/clearall', function () {
    Artisan::call('cache:clear');
    echo '<script>alert("cache clear Success")</script>';
    Artisan::call('config:cache');
    echo '<script>alert("config cache Success")</script>';
    Artisan::call('view:clear');
    echo '<script>alert("view clear Success")</script>';
    Artisan::call('route:cache');
    echo '<script>alert("route clear Success")</script>';
});

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';
