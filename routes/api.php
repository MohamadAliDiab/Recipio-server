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
    Route::post('/block', [UserController::class, 'block'])->name('api:block');
    Route::post('/unblock', [UserController::class, 'unblock'])->name('api:unblock');
    Route::post('/postRecipe', [UserController::class, 'postRecipe'])->name('api:postRecipe');
    Route::get('/getRecipes', [UserController::class, 'getRecipes'])->name('api:getRecipes');
    Route::post('/likeRecipe', [UserController::class, 'likeRecipe'])->name('api:likeRecipe');
    Route::post('/addComment', [UserController::class, 'addComment'])->name('api:addComment');
    Route::post('/likeComment', [UserController::class, 'likeComment'])->name('api:likeComment');
    Route::post('/addReply', [UserController::class, 'addReply'])->name('api:addReply');
    Route::post('/likeReply', [UserController::class, 'likeReply'])->name('api:likeReply');
    Route::post('/followUser', [UserController::class, 'followUser'])->name('api:followUser');
    Route::get('/getRequests', [UserController::class, 'getRequests'])->name('api:getRequests');
    Route::post('/appRequest', [UserController::class, 'appRequest'])->name('api:appRequest');
    Route::post('/declineReq', [UserController::class, 'declineReq'])->name('api:declineReq');
    Route::get('/getUserInfo', [UserController::class, 'getUserInfo'])->name('api:getUserInfo');
    Route::post('/deleteRecipe', [UserController::class, 'deleteRecipe'])->name('api:deleteRecipe');
    Route::post('/deleteComment', [UserController::class, 'deleteComment'])->name('api:deleteComment');
    Route::post('/deleteReply', [UserController::class, 'deleteReply'])->name('api:deleteReply');
    Route::post('/addTag', [UserController::class, 'addTag'])->name('api:addTag');
    Route::post('/removeLikeRecipe', [UserController::class, 'removeLikeRecipe'])->name('api:removeLikeRecipe');
    Route::post('/removeLikeComment', [UserController::class, 'removeLikeComment'])->name('api:removeLikeComment');
    Route::post('/removeLikeReply', [UserController::class, 'removeLikeReply'])->name('api:removeLikeReply');
    Route::get('/getTopRecipes', [UserController::class, 'getTopRecipes'])->name('api:getTopRecipes');
    Route::post('logout', [AuthController::class, 'logout'])->name('api:logout');
});
