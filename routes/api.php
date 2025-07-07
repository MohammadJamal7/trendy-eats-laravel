<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/facebook-login', [AuthController::class, 'facebookLogin']);
Route::post('/instagram-login', [AuthController::class, 'instagramLogin']);

// Countries routes (publicly accessible)
Route::apiResource('countries', CountryController::class)->only(['index', 'show']);
Route::get('/countries/{country}/places', [CountryController::class, 'places']);

// Categories routes (publicly accessible)
Route::apiResource('categories', CategoryController::class);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/user', [\App\Http\Controllers\AuthController::class, 'destroy']);
    Route::get('/user/profile', [\App\Http\Controllers\AuthController::class, 'profile']);
    Route::put('/user/profile', [\App\Http\Controllers\AuthController::class, 'updateProfile']);
    Route::put('/user/change-password', [\App\Http\Controllers\AuthController::class, 'changePassword']);
    Route::post('/places/{place}/favorite', [FavoriteController::class, 'store']);
    Route::delete('/places/{place}/favorite', [FavoriteController::class, 'destroy']);
    Route::get('/user/favorites', [FavoriteController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Places routes
    Route::apiResource('places', PlaceController::class);
});

// Instagram OAuth Routes for API (Flutter)
// Route::get('auth/instagram', [AuthController::class, 'redirectToInstagram']);
// Route::get('auth/instagram/callback', [AuthController::class, 'handleInstagramCallback']);

// Facebook OAuth Routes for API (Flutter)
// Route::get('auth/facebook', [AuthController::class, 'redirectToFacebook']);
// Route::get('auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);
