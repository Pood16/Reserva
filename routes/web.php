<?php
use App\Http\Controllers\auth\AuthController;

use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\Manager\ManagerProfileController;
use App\Http\Controllers\Manager\ManagerReservationController;
use App\Http\Controllers\Manager\ManagerRestaurantController;
use App\Http\Controllers\Manager\MenuController;

use App\Http\Controllers\Client\ReservationController;
use App\Http\Controllers\Client\RestaurantController;
use App\Http\Controllers\Client\FavoriteController;


// use App\Http\Controllers\Trush\RestaurantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Client\ClientHomeController;
use App\Http\Controllers\Client\ClientProfileController;
use App\Http\Controllers\Manager\TableController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Broadcast;
// Broadcast::routes(['middleware' => ['web', 'auth']]);




// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/manager-request', [HomeController::class, 'submitManagerRequest'])->name('manager.request.submit');

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
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

// Static pages
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Auth required routes
Route::middleware(['auth'])->group(function () {

    // Notifications : client
    Route::get('/notifications', [NotificationsController::class, 'getNotifications'])->name('notifications.get');
    Route::post('/notifications/read', [NotificationsController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationsController::class, 'markAllAsRead'])->name('notifications.read-all');

    // client reservations
    Route::prefix('client')->name('client.')->group(function () {
        // Use the ReservationController for client reservations
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/reservations/history', [ReservationController::class, 'history'])->name('reservations.history');
        Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::put('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    });

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::post('/restaurants/{restaurant}/favorite', [FavoriteController::class, 'toggleFavorite'])->name('favorites.toggle');
    Route::get('/restaurants/{restaurant}/favorite/status', [FavoriteController::class, 'checkFavoriteStatus'])->name('favorites.status');

    // Profile settings
    Route::get('/profile', [ClientProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ClientProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ClientProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ClientProfileController::class, 'destroy'])->name('profile.destroy');
});

// restaurant manager routes
Route::middleware(['auth', 'manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerDashboardController::class, 'dashboard'])->name('restaurant.dashboard');
    Route::get('/manager/restaurants', [ManagerRestaurantController::class, 'restaurantsList'])->name('manage.restaurants');
    Route::post('/manager/restaurant/add', [ManagerRestaurantController::class, 'addRestaurant'])->name('restaurant.store');
    Route::put('/manager/restaurant/{id}/status', [ManagerRestaurantController::class, 'toggleStatus'])->name('restaurant.toggle.status');
    Route::get('/manager/restaurant/{id}/edit', [ManagerRestaurantController::class, 'showEditRestaurant'])->name('restaurant.update.show');
    Route::put('/manager/restaurant/{id}/update', [ManagerRestaurantController::class, 'updateRestaurant'])->name('restaurant.update');
    Route::get('/manager/restaurant/{id}', [ManagerRestaurantController::class, 'restaurantDetails'])->name('restaurant.details');
    Route::post('/manager/restaurant/{id}/images', [ManagerRestaurantController::class, 'addRestaurantImage'])->name('restaurant.images.add');
    Route::delete('/manager/restaurant/{id}/images/{imageId}', [ManagerRestaurantController::class, 'deleteRestaurantImage'])->name('restaurant.images.delete');

    // Table management routes
    Route::get('/manager/restaurant/{restaurantId}/tables', [TableController::class, 'index'])->name('manager.tables.index');
    Route::post('/manager/restaurant/{restaurantId}/tables', [TableController::class, 'store'])->name('manager.tables.store');
    Route::put('/manager/restaurant/{restaurantId}/tables/{id}', [TableController::class, 'update'])->name('manager.tables.update');
    Route::delete('/manager/restaurant/{restaurantId}/tables/{id}', [TableController::class, 'destroy'])->name('manager.tables.destroy');
    Route::put('/manager/restaurant/{restaurantId}/tables/{id}/toggle-availability', [TableController::class, 'toggleAvailability'])->name('manager.tables.toggle-availability');
    Route::put('/manager/restaurant/{restaurantId}/tables/{id}/toggle-active', [TableController::class, 'toggleActive'])->name('manager.tables.toggle-active');

    // Menu management routes
    Route::get('/manager/restaurant/{restaurantId}/menus', [MenuController::class, 'index'])->name('manager.menus.index');
    Route::get('/manager/restaurant/{restaurantId}/menus/create', [MenuController::class, 'create'])->name('manager.menus.create');
    Route::post('/manager/restaurant/{restaurantId}/menus', [MenuController::class, 'store'])->name('manager.menus.store');
    Route::get('/manager/restaurant/{restaurantId}/menus/{menuId}/edit', [MenuController::class, 'edit'])->name('manager.menus.edit');
    Route::put('/manager/restaurant/{restaurantId}/menus/{menuId}', [MenuController::class, 'update'])->name('manager.menus.update');
    Route::delete('/manager/restaurant/{restaurantId}/menus/{menuId}', [MenuController::class, 'destroy'])->name('manager.menus.destroy');

    // Menu items management routes
    Route::get('/manager/restaurant/{restaurantId}/menus/{menuId}/items', [MenuController::class, 'showItems'])->name('manager.menus.items');
    Route::post('/manager/restaurant/{restaurantId}/menus/{menuId}/items', [MenuController::class, 'storeItem'])->name('manager.menus.items.store');
    Route::get('/manager/restaurant/{restaurantId}/menus/{menuId}/items/{itemId}/edit', [MenuController::class, 'editItem'])->name('manager.menus.items.edit');
    Route::put('/manager/restaurant/{restaurantId}/menus/{menuId}/items/{itemId}', [MenuController::class, 'updateItem'])->name('manager.menus.items.update');
    Route::delete('/manager/restaurant/{restaurantId}/menus/{menuId}/items/{itemId}', [MenuController::class, 'destroyItem'])->name('manager.menus.items.destroy');
    Route::put('/manager/restaurant/{restaurantId}/menus/{menuId}/items/{itemId}/toggle', [MenuController::class, 'toggleItemAvailability'])->name('manager.menus.items.toggle');

    // Manager Profile Routes
    Route::get('/manager/profile', [ManagerProfileController::class, 'show'])->name('manager.profile.show');
    Route::get('/manager/profile/edit', [ManagerProfileController::class, 'edit'])->name('manager.profile.edit');
    Route::put('/manager/profile', [ManagerProfileController::class, 'update'])->name('manager.profile.update');
    Route::get('/manager/profile/change-password', [ManagerProfileController::class, 'showChangePasswordForm'])->name('manager.profile.password.edit');
    Route::put('/manager/profile/change-password', [ManagerProfileController::class, 'updatePassword'])->name('manager.profile.password.update');

    // Manager Reservation Routes
    Route::get('/manager/reservations', [ManagerReservationController::class, 'index'])->name('manager.reservations');
    Route::get('/manager/reservations/{id}', [ManagerReservationController::class, 'show'])->name('manager.reservations.show');
    Route::put('/manager/reservations/{id}/approve', [ManagerReservationController::class, 'approve'])->name('manager.reservations.approve');
    Route::put('/manager/reservations/{id}/decline', [ManagerReservationController::class, 'decline'])->name('manager.reservations.decline');
    Route::put('/manager/reservations/{id}/complete', [ManagerReservationController::class, 'complete'])->name('manager.reservations.complete');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Manager Requests Management
    Route::get('/manager-requests', [AdminController::class, 'managerRequestsIndex'])->name('admin.manager-requests.index');
    Route::post('/manager-requests/{id}/approve', [AdminController::class, 'managerRequestsApprove'])->name('admin.manager-requests.approve');
    Route::post('/manager-requests/{id}/reject', [AdminController::class, 'managerRequestsReject'])->name('admin.manager-requests.reject');
    Route::delete('/manager-requests/{id}', [AdminController::class, 'managerRequestsDestroy'])->name('admin.manager-requests.destroy');

    // Restaurant Managers Management
    Route::get('/restaurant-managers', [AdminController::class, 'restaurantManagersIndex'])->name('admin.restaurant-managers.index');

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
