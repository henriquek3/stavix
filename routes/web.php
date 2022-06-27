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

Route::get('/', function () {
    return view('welcome');
});

Route::get('stavix', [\App\Http\Controllers\StavixController::class, 'index']);
Route::post('stavix', [\App\Http\Controllers\StavixController::class, 'store']);
Route::get('stavix/post', [\App\Http\Controllers\StavixController::class, 'sendRequest']);


Route::get('config', [\App\Http\Controllers\ConfigStavixController::class, 'index']);
