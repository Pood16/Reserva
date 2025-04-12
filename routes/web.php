<?php

use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Configuration\Middleware;

Route::get('/', [App\Http\Controllers\RestaurantController::class, 'index'])->name('welcome');

Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');



Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.handle');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.handle');
Route::get('/logout', [AuthController::class, 'handleLogout'])->middleware('auth')->name('logout.handle');




Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::get('/client/dashboard', function () {
    return view('client.dashboard');
})->name('client.dashboard');

Route::middleware(['manager'])->group(function () {
    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');
});

// Restaurant routes
Route::get('/restaurants/{id}', [App\Http\Controllers\RestaurantController::class, 'show'])->name('restaurants.show');
Route::post('/reservations', [App\Http\Controllers\RestaurantController::class, 'storeReservation'])->middleware('auth')->name('reservations.store');
