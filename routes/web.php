<?php

use App\Http\Controllers\AdminController\AdminController;
use App\Http\Controllers\AuthController\AuthController;
use App\Http\Controllers\CartItemController\CartItemController;
use App\Http\Controllers\Manager\InventoryController\InventoryController;
use App\Http\Controllers\Manager\OrderController\OrderController as ManagerOrderController;
use App\Http\Controllers\Manager\ProductController\ProductController as ManagerProductController;
use App\Http\Controllers\Manager\ReportController\ReportController;
use App\Http\Controllers\OrderController\OrderController;
use App\Http\Controllers\ProductController\ProductController;
use App\Http\Controllers\RefundRequestController\RefundRequestController;
use App\Http\Controllers\ReviewController\ReviewController;
use App\Http\Controllers\UserProfileController\UserProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::resource('products', ProductController::class)->only(['index', 'show']);
    //Manager product controller
    Route::resource('manager/products', ManagerProductController::class);

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

    Route::middleware( 'isAdmin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
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

    Route::middleware('isManager')->group(function () {
        Route::get('manager/dashboard', [ReportController::class, 'index'])->name('manager.reports.index');
    });

    Route::middleware('isManager')->group(function () {
        Route::get('manager/inventory', [InventoryController::class, 'index'])->name('manager.inventory.index');
    });
});
