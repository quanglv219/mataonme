<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\LinkPageController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\Payment\PlansController;
use App\Http\Controllers\Payment\SubscriptionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SocialMediaLinksController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

// Public Analytics (Privates one are on the group below)
Route::put('/clicks/add', [LinkPageController::class, 'analytic']);
Route::put('/views/add', [LinkPageController::class, 'countViews']);

// Private Routes
Route::group(['middleware' => ['auth', 'checkSubscription']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/user/settings', [SettingsController::class, 'index'])->name('user.settings');
    Route::post('/user/settings', [SettingsController::class, 'update']);
    Route::put('/user/social', [SocialMediaLinksController::class, 'update']);
    Route::put('/password/change', [ChangePasswordController::class, 'update']);
    Route::put('/all/links/updateAll', [LinksController::class, 'updateAll']);
    Route::resource('/links', LinksController::class);
    Route::post('/user', [UserController::class, 'update']);
    Route::resource('/customization', CustomizationController::class);
    Route::post('/customize/backgroundImage', [CustomizationController::class, 'uploadImage']);
    Route::put('/customization', [CustomizationController::class, 'update']);
    Route::put('/change/background', [CustomizationController::class, 'changeTheme']);

    // Private Analytics
    Route::post('/analytics/analytic', [AnalyticsController::class, 'analytic']);
    Route::post('/analytics/views', [AnalyticsController::class, 'getViews']);

    // Stripe & Cashier
    Route::get('/upgrade', [SubscriptionController::class, 'index'])->name('upgrade');
    Route::post('/user/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscription.create');
    Route::post('/user/subscription/cancel', [SubscriptionController::class, 'cancel']);
    Route::get('/plans/premium', [PlansController::class, 'index']);

    // Admins
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::resource('/users', UsersController::class);
        Route::get('/settings', [DashboardController::class, 'settings'])->name('settings.index');
        Route::post('/settings', [DashboardController::class, 'update'])->name('settings.update');
    });
});
Route::get('/{username}', [LinkPageController::class, 'show']);

Route::fallback(function () {
    abort(404);
});
