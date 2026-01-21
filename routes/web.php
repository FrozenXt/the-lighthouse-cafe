<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ReservationController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Menu
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/menu/{category}', [MenuController::class, 'category'])->name('menu.category');

// Membership
Route::get('/membership', [MembershipController::class, 'index'])->name('membership');
Route::post('/membership/register', [MembershipController::class, 'register'])->name('membership.register');

// Reservations
Route::get('/reservations', [ReservationController::class, 'create'])->name('reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');

// About & Contact
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');