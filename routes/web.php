<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group. Make something great!
 * |
 */

// Home
Route::redirect('/', '/home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Authentication
Route::controller(LoginController::class)->group(function () {
  Route::get('/login', 'showLoginForm')->name('login');
  Route::post('/login', 'authenticate');
  Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
  Route::get('/register', 'showRegistrationForm')->name('register');
  Route::post('/register', 'register');
});

// Auctions
Route::prefix('auctions')->group(function () {
  Route::get('search', [AuctionController::class, 'search'])->name('auctions.search');
});
