<?php
//
//use App\Http\Controllers\AuthController\AuthController;
//use App\Http\Controllers\CartItemController\CartItemController;
//use App\Http\Controllers\OrderController\OrderController;
//use App\Http\Controllers\ProductController\ProductController;
//use App\Http\Controllers\ReviewController\ReviewController;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Route;
//
//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
//
////auth controller(public routes)
//Route::controller(AuthController::class)->prefix('auth')->group(function () {
//    Route::post('/register', 'register');
//    Route::post('/login', 'login');
//    Route::get('/login', 'showLogin');
//});
//
//Route::post('/stripe/webhook', [OrderController::class, 'webhook']);
//
//Route::middleware('auth:sanctum')->group(function () {
//    Route::post('/auth/logout', [AuthController::class, 'logout']);
//
//    Route::apiResource('products', ProductController::class);
//
//    Route::controller(CartItemController::class)->group(function () {
//        Route::get('/cart', 'index');
//        Route::post('/cart/add', 'add');
//        Route::put('/cart/update/{productId}', 'update');
//        Route::delete('/cart/remove/{productId}', 'remove');
//        Route::delete('/cart/clear', 'clear');
//    });
//
//    Route::controller(OrderController::class)->group(function () {
//        Route::get('/orders', 'show');
//        Route::post('/orders', 'placeOrder');
//    });
//
//    Route::controller(ReviewController::class)->group(function () {
//        Route::post('/review', 'addReview');
//        Route::get('/review', 'getReviews');
//    });
//
//
//});
//
//
