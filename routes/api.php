<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [UserController::class, 'register'])->name('api:register');
Route::post('/login', [AuthController::class, 'login'])->name('api:login');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('/search/{keyword}', [UserController::class, 'search'])->name('api:search');
    Route::post('logout', [AuthController::class, 'logout'])->name('api:logout');
});
