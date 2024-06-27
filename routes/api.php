<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\TheaterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/send-email', [AuthController::class, 'sendEmail']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::middleware(['auth:api', 'auth.refreshtoken'])->group(function() {
    Route::get('/profile', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});

// Movie
Route::get('/movies', [MovieController::class, 'listMovie']);
Route::get('/movies/{id}', [MovieController::class, 'detailMovie']);

// Banner
Route::get('/banners', [BannerController::class, 'getBanner']);

// Event
Route::get('/events', [EventController::class, 'listEvent']);

// Theater
Route::get('/theaters', [TheaterController::class, 'listTheater']);
Route::get('/theaters/{id}', [TheaterController::class, 'theaterDetail']);