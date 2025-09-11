<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController\AuthController;
use App\Http\Controllers\ProductController\ProductController;
use App\Http\Controllers\CartItemController\CartItemController;
use App\Http\Controllers\OrderController\OrderController;
use App\Http\Controllers\Manager\OrderController as ManagerOrderController;
use App\Http\Controllers\RefundRequestController;
use App\Http\Controllers\ReviewController\ReviewController;
use App\Http\Controllers\UserProfileController\UserProfileController;

Route::get('/', fn() => view('welcome'));

// Example: user check
Route::get('/user', fn(Request $request) => $request->user())->middleware('auth:sanctum');


// ---------------- AUTH ROUTES ---------------- //
Route::prefix('auth')->middleware('guest')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::get('/register', 'showRegister');
    Route::post('/login', 'login');
    Route::get('/login', 'showLogin')->name('login');
});


// ---------------- PROTECTED ROUTES ---------------- //
Route::middleware('auth')->group(function () {

    // logout
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Products
    Route::resource('products', ProductController::class);

    // Cart
    Route::controller(CartItemController::class)->group(function () {
        Route::get('/cart', 'index');
        Route::post('/cart/add', 'add');
        Route::put('/cart/update/{productId}', 'update');
        Route::delete('/cart/remove/{productId}', 'remove');
        Route::delete('/cart/clear', 'clear');
    });

    // Orders (User side)
    Route::controller(OrderController::class)->group(function () {
        Route::get('/orders', 'index')->name('orders.index');
        Route::post('/orders', 'placeOrder');
        Route::post('/order/{id}/pay', 'pay')->name('order.pay');

        Route::get('/payment/success', 'success')->name('payment.success');
        Route::get('/payment/failed', 'failed')->name('payment.failed');
    });


    // ---------------- MANAGER ROUTES ---------------- //
    Route::prefix('manager')->name('manager.')->middleware('isManager')->group(function () {
        // Manager Orders
        Route::resource('orders', ManagerOrderController::class)->only(['index', 'show']);
        Route::post('orders/{order}/approve', [ManagerOrderController::class, 'approve'])->name('orders.approve');
        Route::post('orders/{order}/reject', [ManagerOrderController::class, 'reject'])->name('orders.reject');
        Route::post('orders/{order}/refund', [ManagerOrderController::class, 'refund'])->name('orders.refund');

        // Manager Refund Requests
        Route::get('/refunds', [RefundRequestController::class, 'index'])->name('refunds.index');
        Route::post('/refunds/{id}/approve', [RefundRequestController::class, 'approve'])->name('refunds.approve');
    });


    // ---------------- USER REFUND REQUEST ---------------- //
    Route::post('/refunds', [RefundRequestController::class, 'store'])->name('refunds.store');


    // ---------------- REVIEWS ---------------- //
    Route::controller(ReviewController::class)->group(function () {
        Route::post('/review', 'addReview');
        Route::get('/review', 'getReviews');
    });

    // ---------------- USER PROFILE ---------------- //
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
});
