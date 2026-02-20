<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DishController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\MemberController;

// Storage Files - Serve uploaded images and files (Must be first to avoid conflicts)
Route::get('/storage/{path}', function ($path) {
    $storagePath = storage_path('app/public/' . $path);

    if (!file_exists($storagePath)) {
        abort(404);
    }

    return response()->file($storagePath);
})->where('path', '.*')->name('storage.file');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{category}', [MenuController::class, 'category'])->name('menu.category');

// Membership
Route::get('/membership', [MembershipController::class, 'index'])->name('membership');
Route::post('/membership/register', [MembershipController::class, 'register'])->name('membership.register');

// Reservations
Route::get('/reservations', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

// Orders
Route::get('/order', [OrderController::class, 'index'])->name('orders.index');
Route::get('/cart', [OrderController::class, 'cart'])->name('orders.cart');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/checkout/success/{order_id}', [OrderController::class, 'checkoutSuccess'])->name('orders.checkout.success');
Route::get('/orders/checkout/cancel/{order_id}', [OrderController::class, 'checkoutCancel'])->name('orders.checkout.cancel');
Route::get('/orders/{id}/success', [OrderController::class, 'success'])->name('orders.success');
Route::get('/orders/track/{orderNumber}', [OrderController::class, 'track'])->name('orders.track');

// About & Contact
Route::view('/about', 'about')->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

    // Protected Admin Routes
    Route::middleware('auth:admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Orders Management
        Route::get('/orders', [DashboardController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [DashboardController::class, 'showOrder'])->name('orders.show');
        Route::post('/orders/{order}/status', [DashboardController::class, 'updateOrderStatus'])->name('orders.update-status');
        Route::delete('/orders/{order}', [DashboardController::class, 'deleteOrder'])->name('orders.delete');

        // Dishes/Menu Management
        Route::resource('dishes', DishController::class);
        Route::post('/dishes/{dish}/toggle-availability', [DishController::class, 'toggleAvailability'])->name('dishes.toggle-availability');

        // Categories Management
        Route::resource('categories', CategoryController::class);
        Route::post('/categories/{category}/toggle-active', [CategoryController::class, 'toggleActive'])->name('categories.toggle-active');

        // Reservations Management
        Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
        Route::post('/reservations/{reservation}/status', [AdminReservationController::class, 'updateStatus'])->name('reservations.update-status');
        Route::delete('/reservations/{reservation}', [AdminReservationController::class, 'destroy'])->name('reservations.delete');

        // Members Management
        Route::get('/members', [MemberController::class, 'index'])->name('members.index');
        Route::get('/members/{member}', [MemberController::class, 'show'])->name('members.show');
        Route::put('/members/{member}', [MemberController::class, 'update'])->name('members.update');
        Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('members.delete');

        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});
