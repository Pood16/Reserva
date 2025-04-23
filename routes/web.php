<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Manager\TableController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Configuration\Middleware;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.handle');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.handle');
Route::post('/logout', [AuthController::class, 'handleLogout'])->middleware('auth')->name('logout');




// Restaurant listing and details
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{id}', [RestaurantController::class, 'show'])->name('restaurants.show');
Route::post('/restaurants/{id}/favorite', [RestaurantController::class, 'toggleFavorite'])->middleware('auth')->name('restaurants.favorite');

// Static pages
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Auth required routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Profile settings
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Restaurant owner routes
Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('restaurant.dashboard');
    Route::get('/manager/restaurants', [ManagerController::class, 'restaurantsList'])->name('manage.restaurants');
    Route::post('/manager/restaurant/add', [ManagerController::class, 'addRestaurant'])->name('restaurant.store');
    Route::put('/manager/restaurant/{id}/status', [ManagerController::class, 'toggleStatus'])->name('restaurant.toggle.status');
    Route::get('/manager/restaurant/{id}', [ManagerController::class, 'restaurantDetails'])->name('restaurant.details');
    Route::post('/manager/restaurant/{id}/images', [ManagerController::class, 'addRestaurantImage'])->name('restaurant.images.add');
    Route::delete('/manager/restaurant/{id}/images/{imageId}', [ManagerController::class, 'deleteRestaurantImage'])->name('restaurant.images.delete');

    // Table management routes for manager
    Route::get('/manager/restaurant/{restaurantId}/tables', [TableController::class, 'index'])->name('manager.tables.index');
    Route::post('/manager/restaurant/{restaurantId}/tables', [TableController::class, 'store'])->name('manager.tables.store');
    Route::put('/manager/restaurant/{restaurantId}/tables/{id}', [TableController::class, 'update'])->name('manager.tables.update');
    Route::delete('/manager/restaurant/{restaurantId}/tables/{id}', [TableController::class, 'destroy'])->name('manager.tables.destroy');
    Route::put('/manager/restaurant/{restaurantId}/tables/{id}/toggle-availability', [TableController::class, 'toggleAvailability'])->name('manager.tables.toggle-availability');
    Route::put('/manager/restaurant/{restaurantId}/tables/{id}/toggle-active', [TableController::class, 'toggleActive'])->name('manager.tables.toggle-active');

    // Route::get('/restaurants', [RestaurantController::class, 'ownerIndex'])->name('restaurant_owner.restaurants.index');
    Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurant_owner.restaurants.create');
    Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurant_owner.restaurants.store');
    Route::get('/restaurants/{id}/edit', [RestaurantController::class, 'edit'])->name('restaurant_owner.restaurants.edit');
    Route::put('/restaurants/{id}', [RestaurantController::class, 'update'])->name('restaurant_owner.restaurants.update');

    Route::get('/reservations', [ReservationController::class, 'ownerIndex'])->name('restaurant_owner.reservations.index');
    Route::put('/reservations/{id}/status', [ReservationController::class, 'updateStatus'])->name('restaurant_owner.reservations.update_status');

    Route::get('/tables', [RestaurantController::class, 'tableIndex'])->name('restaurant_owner.tables.index');
    Route::get('/tables/create', [RestaurantController::class, 'tableCreate'])->name('restaurant_owner.tables.create');
    Route::post('/tables', [RestaurantController::class, 'tableStore'])->name('restaurant_owner.tables.store');
    Route::get('/tables/{id}/edit', [RestaurantController::class, 'tableEdit'])->name('restaurant_owner.tables.edit');
    Route::put('/tables/{id}', [RestaurantController::class, 'tableUpdate'])->name('restaurant_owner.tables.update');
    Route::delete('/tables/{id}', [RestaurantController::class, 'tableDestroy'])->name('restaurant_owner.tables.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User management
    Route::get('/users', [AdminController::class, 'userIndex'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class, 'userCreate'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'userStore'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'userEdit'])->name('admin.users.edit');
    Route::put('/users/{id}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
    Route::delete('/users/{id}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy');

    // Restaurant management
    Route::get('/restaurants', [AdminController::class, 'restaurantIndex'])->name('admin.restaurants.index');
    Route::get('/restaurants/{id}/edit', [AdminController::class, 'restaurantEdit'])->name('admin.restaurants.edit');
    Route::put('/restaurants/{id}', [AdminController::class, 'restaurantUpdate'])->name('admin.restaurants.update');
    Route::delete('/restaurants/{id}', [AdminController::class, 'restaurantDestroy'])->name('admin.restaurants.destroy');

    // System settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
});
