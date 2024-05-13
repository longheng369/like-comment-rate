<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsController;
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

// Route::post('/register', [AuthApiController::class, 'register']);
// Route::post('/login', [AuthApiController::class, 'login']);
// Route::get('/login/google', [AuthApiController::class, 'redirectToProvider']);
// Route::get('/login/google/callback', [AuthApiController::class, 'handleProviderCallback']);


// Route::group(['middleware' => 'auth:sanctum'], function () {
//     Route::get('/logout', [AuthApiController::class, 'logout']);
//     Route::get('/profile', [AuthApiController::class, 'profile']);
//     Route::get('/getIsLiked', [ApiController::class, 'getIsLiked']);

//     Route::post('/products/{product}/upvote', [VoteController::class, 'upvote']);
//     Route::post('/products/{product}/downvote', [VoteController::class, 'downvote']);

//     Route::post('/products/{product}/comment', [CommentController::class, 'store']);
//     Route::post('/products/{product}/rate', [RateController::class, 'store']);

//     Route::post('products/{productId}/favorite', [ProductController::class, 'addFavorite']);
//     Route::delete('products/{productId}/favorite', [ProductController::class, 'removeFavorite']);
//     Route::get('/users/favorites', [ProductController::class, 'showFavorites']);
//     Route::get('/items-with-likes-favorites',[ProductController::class,'getItemsWithLikes']);
// });
Route::get('/all',[ProductsController::class, 'index']);