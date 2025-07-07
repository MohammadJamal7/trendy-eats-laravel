<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\ImageController;

Route::get('/', function () {
    return view('welcome');
});

// Serve uploaded images
Route::get('images/{path}', [ImageController::class, 'serve'])->where('path', '.*');
Route::options('images/{path}', [ImageController::class, 'handleOptions'])->where('path', '.*');

// Test route to debug file serving
Route::get('test-image', function () {
    $fullPath = storage_path('app/public/places/99rNHAa2YtyMeybWpss3cO5ssZhP9GGQ8S2RuRcE.png');
    return [
        'path' => $fullPath,
        'exists' => file_exists($fullPath),
        'readable' => is_readable($fullPath)
    ];
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('places', \App\Http\Controllers\Admin\PlaceController::class);
        Route::resource('countries', \App\Http\Controllers\Admin\CountryController::class);
    });
});

// OAuth Routes for Flutter (with session support)
Route::get('auth/instagram', [AuthController::class, 'redirectToInstagram']);
Route::get('auth/instagram/callback', [AuthController::class, 'handleInstagramCallback']);
Route::get('auth/facebook', [AuthController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);
