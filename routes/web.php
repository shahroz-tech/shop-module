<?php

use App\Http\Controllers\AdminController\AdminController;
use App\Http\Controllers\AuthController\AuthController;
use App\Http\Controllers\CartItemController\CartItemController;
use App\Http\Controllers\InventoryController\InventoryController;
use App\Http\Controllers\OrderController\OrderController;
use App\Http\Controllers\ProductController\ProductController;
use App\Http\Controllers\RefundRequestController\RefundRequestController;
use App\Http\Controllers\ReportController\ReportController;
use App\Http\Controllers\ReviewController\ReviewController;
use App\Http\Controllers\UserController\UserController;
use App\Http\Controllers\UserProfileController\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

// Example: user check
Route::get('/user', fn(Request $request) => $request->user())->middleware('auth:sanctum');


// ---------------- AUTH ROUTES ---------------- //
Route::prefix('auth')->middleware('guest')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register')  ;
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
    Route::middleware('isNotCustomer')->group(function () {
        // Manager Orders
        Route::get('manage/orders', [OrderController::class,'getAllOrders'])->name('orders.allOrders');
        Route::post('/orders/{order}/approve', [OrderController::class, 'approve'])->name('orders.approve');
        Route::post('/orders/{order}/reject', [OrderController::class, 'reject'])->name('orders.reject');
        Route::post('/orders/{order}/refund', [OrderController::class, 'refund'])->name('orders.refund');

        // Manager Refund Requests
        Route::get('/refunds', [RefundRequestController::class, 'index'])->name('refunds.index');
        Route::post('/refunds/{id}/approve', [RefundRequestController::class, 'approve'])->name('refunds.approve');

        Route::get('/dashboard', [ReportController::class, 'index'])->name('reports.index');

        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::resource('users', UserController::class)->except(['edit', 'update','show']);



    });

    Route::middleware('isAdmin')->prefix('admin')->group(function () {
        Route::post('/users/{id}/role', [AdminController::class, 'assignRole'])->name('admin.assignRole');
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
