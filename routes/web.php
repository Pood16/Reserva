<?php

use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
Route::post('/register', [AuthController::class, 'handleRegister'])->name('register.handle');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
Route::post('/login', [AuthController::class, 'handleLogin'])->name('login.handle');
