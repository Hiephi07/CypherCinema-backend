<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\Banner\BannerController;
use App\Http\Controllers\API\Event\EventController;
use App\Http\Controllers\API\Movie\MovieController;
use App\Http\Controllers\API\Paymentmethod\PaymentMethodController;
use App\Http\Controllers\API\Seat\SeatController;
use App\Http\Controllers\API\Showtime\ShowtimeController;
use App\Http\Controllers\API\Theater\TheaterController;
use App\Http\Controllers\API\Voucher\VoucherController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\EmailVerificationController;

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

Route::group([
    'middleware' => 
        [
            'api',
            'auth.jwt',
            'verified.email',
            'throttle:api', // rate-limiting
        ]
], function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::post('refresh', [UserController::class, 'refresh']);
    Route::get('profile', [UserController::class, 'profile']);
});

Route::middleware(['auth.jwt'])->group(function () {
    // Gửi lại Email xác minh
    Route::post('/email/verification-notification', [
        EmailVerificationController::class, 'sendVerificationEmail'
    ]);

    // Xác minh Email
    Route::get('/email/verify/{id}/{hash}', [
        EmailVerificationController::class, 'verify'
    ])
    ->name('verification.verify');
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/password/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [ResetPasswordController::class, 'reset']);


//////////////////////////////////////////////////////////////////////////////////////////

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

// Book movie tickets
Route::get('/book-tickets/movies/{id}/showtimes', [ShowtimeController::class, 'getShowtimes']);
Route::get('/book-tickets/movies/{movieID}/showtimes/{showtimeID}/seats', [SeatController::class, 'seats']);

Route::get('/payment-methods', [PaymentMethodController::class, 'getAll']);
Route::post('/vouchers', [VoucherController::class, 'applyVoucher']);



