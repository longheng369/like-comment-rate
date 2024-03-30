<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\VoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/logout', [AuthApiController::class, 'logout']);
    Route::get('/profile', [AuthApiController::class, 'profile']);

    Route::post('/products/{product}/upvote', [VoteController::class, 'upvote']);
    Route::post('/products/{product}/downvote', [VoteController::class, 'downvote']);

    Route::post('/products/{product}/comment', [CommentController::class, 'store']);
    Route::post('/products/{product}/rate', [RateController::class, 'store']);

    Route::get('/all',[ApiController::class, 'index']);
});