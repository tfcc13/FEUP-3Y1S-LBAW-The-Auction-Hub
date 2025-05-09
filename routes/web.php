<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MoneyController;
use App\Http\Controllers\NotificationController;
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

Route::get('/banned', function () {
    return view('pages.error.banned');
})->name('banned');

Route::get('/deleted', function () {
    return view('pages.error.deleted');
})->name('deleted');

// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
    Route::get('login/google', 'redirectToGoogle')->name('google-auth');
    Route::get('auth/google/call-back', 'callbackGoogle')->name('google-call-back');

});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// Terms and Privacy routes
Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('search', [SearchController::class, 'searchView'])->name('search.view');

Route::middleware(['not.banned', 'not.deleted'])->group(function () {
    // Home
    Route::redirect('/', '/home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::middleware(['auth'])->group(function () {
        // User
        Route::prefix('user')->name('user.')->group(function () {
            Route::delete('/delete/user/{id}', [DeleteController::class, 'deleteUser'])->name('deleteUser');
            Route::get('/dashboard', function () {
                return view('pages.user.dashboard.dashboard');
            })->name('dashboard');
            Route::put('/description', [UserController::class, 'updateDescription'])->name('updateDescription');
            Route::get('/dashboard/stats', [UserController::class, 'showStatistics'])->name('dash.stats');
            Route::get('/dashboard/financial', [UserController::class, 'showFinancial'])->name('dash.financial');
            Route::post('/user/add-money', [UserController::class, 'addMoney'])->name('add-money');
            Route::get('/profile/{username}', [UserController::class, 'showProfile'])->name('profile.other');
            Route::get('follow', [UserController::class, 'followedAuctions'])->name('follow.auctions');
            Route::get('/dashboard/bids', [UserController::class, 'showBids'])->name('dash.bids');
            Route::get('/dashboard/auctions', [UserController::class, 'showUserAuctions'])->name('dash.auctions');
            Route::post('{userId}/deposit-money', [MoneyController::class, 'depositMoney'])->name('deposit-money');
            Route::post('{userId}/withdraw-money', [MoneyController::class, 'withdrawMoney'])->name('withdraw-money');
            Route::get('/dashboard/bids', [UserController::class, 'showBids'])->name('dash.bids');
            Route::get('/transactions', [UserController::class, 'getTransactions'])->name('user.transactions');
            Route::post('/profile-picture', [UserController::class, 'updateProfilePicture'])->name('profile.picture.update');
        });
        // Auctions
        Route::prefix('auctions')->group(function () {
            Route::get('/auction/{id}', [AuctionController::class, 'showAuction'])->name('auctions.show');
            Route::get('/category/{id}', [AuctionController::class, 'showCategory'])->name('category.show');
            Route::post('/auction/{id}/bid', [AuctionController::class, 'bidAuction'])->name('auction.bid');
            Route::get('/create_auction', [AuctionController::class, 'createAuction'])->name('auctions.create_auction');
            Route::post('/submit_auction', [AuctionController::class, 'submitAuction'])->name('auctions.submit_auction');
            Route::post('/auction/{id}/cancel_auction', [AuctionController::class, 'cancelAuction'])->name('auction.cancel_auction');
            Route::get('/auction/{id}/edit', [AuctionController::class, 'editAuction'])->name('auction.edit_auction');
            Route::put('/auction/{id}', [AuctionController::class, 'update'])->name('auction.update');
            Route::delete('/auction/{id}/delete', [AuctionController::class, 'deleteAuction'])->name('auction.delete')->middleware('auth');
            Route::get('/search/upcoming', [AuctionController::class, 'upcomingAuctions'])->name('search.upcoming');
            Route::get('/auction-state/{id}', [AuctionController::class, 'getAuctionState'])->name('auction_state.fetch');
            Route::post('/report/{id}', [AuctionController::class, 'report'])->name('auction.report');
            Route::post('/auctions/{auction}/follow', [AuctionController::class, 'toggleFollow'])->name('auctions.follow')->middleware('auth');
            Route::get('/related-auctions', [AuctionController::class, 'relatedAuctions']);
        });
        // Notifications
        Route::prefix('notifications')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
            Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
            Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
            Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
        });
        Route::prefix('admin')->group(function () {
            Route::middleware(['admin'])->name('admin.')->group(function () {
                Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
                Route::get('/statistics', [AdminController::class, 'statistics'])->name('dashboard.statistics');
                Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
                Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
                Route::get('/dashboard/users', [AdminController::class, 'dashboardUsers'])->name('dashboard.users');
                Route::get('/dashboard/categories', [AdminController::class, 'dashboardCategorie'])->name('dashboard.categories');
                Route::delete('/delete/user/{id}', [DeleteController::class, 'deleteUser'])->name('deleteUser');
                Route::delete('/delete/category/{id}', [AdminController::class, 'deleteCategory'])->name('deleteCategory');
                Route::put('/ban/user/{id}', [AdminController::class, 'banUser'])->name('banUser');
                Route::get('/dashboard/auctions', [AdminController::class, 'dashboardAuctions'])->name('dashboard.auctions');
                Route::post('/create/category', [AdminController::class, 'createCategory'])->name('createCategory');
                Route::put('/unban/user/{id}', [AdminController::class, 'unbanUser'])->name('unbanUser');
                Route::put('/promote/user/{id}', [AdminController::class, 'promoteUser'])->name('promoteUser');
                Route::get('search', [SearchController::class, 'searchDash'])->name('search.dash');
                Route::get('search/auctions', [SearchController::class, 'searchAuctions'])->name('search.auction');
                Route::get('dashboard/transactions', [AdminController::class, 'showTransactions'])->name('dashboard.transactions');
                Route::patch('/dashboard/transactions/approve/{id}', [MoneyController::class, 'approveTransaction'])->name('transactions.approve');
                Route::patch('/dashboard/transactions/reject/{id}', [MoneyController::class, 'rejectTransaction'])->name('transactions.reject');
            });
        });
    });
});
