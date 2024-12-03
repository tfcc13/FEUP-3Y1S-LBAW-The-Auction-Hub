<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
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
  Route::get('/auction/{id}', [AuctionController::class, 'showAuction'])->name('auctions.show');
  Route::post('/auction/{id}/bid', [AuctionController::class, 'bidAuction'])->name('auction.bid');
  Route::get('/create_auction', [AuctionController::class, 'createAuction'])->name('auctions.create_auction');
  Route::post('/submit_auction', [AuctionController::class, 'submitAuction'])->name('auctions.submit_auction');
  Route::post('/auction/{id}/cancel_auction', [AuctionController::class, 'cancelAuction'])->name('auction.cancel_auction');
  Route::get('/auction/{id}/edit', [AuctionController::class, 'editAuction'])->name('auction.edit_auction');
  Route::put('/auction/{id}', [AuctionController::class, 'update'])->name('auction.update');
  Route::delete('/auction/{id}/delete', [AuctionController::class, 'deleteAuction'])->name('auction.delete')->middleware('auth');
  Route::get('/search/upcoming', [AuctionController::class, 'upcomingAuctions'])->name('search.upcoming');
});

Route::get('search', [SearchController::class, 'searchView'])->name('auctions.search.view');
// User
Route::get('/dashboard', function () {
  return view('pages.user.dashboard');
});
Route::put('/user/description', [UserController::class, 'updateDescription'])->name('user.updateDescription');
Route::get('/profile/{username}', [UserController::class, 'showProfile'])->name('user.profile.other');

Route::post('/user/add-money', [UserController::class, 'addMoney'])->name('user.add-money');
