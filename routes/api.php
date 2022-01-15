<?php

use App\Http\Controllers\Api\BookableAvailabilityController;
use App\Http\Controllers\Api\BookableController;
use App\Http\Controllers\Api\BookablePriceController;
use App\Http\Controllers\Api\BookableReviewController;
use App\Http\Controllers\Api\BookingByReviewController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\ReviewController;
use App\Models\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('bookables')->group(function () {
    Route::get('', [BookableController::class, 'index']);
    Route::get('/{id}', [BookableController::class, 'show']);
});

Route::apiResource('bookables', BookableController::class)->only(['index', 'show']);
Route::get('bookables/{bookable}/availability', BookableAvailabilityController::class);
Route::get('bookables/{bookable}/reviews', BookableReviewController::class)->name('bookables.reviews.index');
Route::get('bookables/{bookable}/price', BookablePriceController::class)->name('bookables.price.show');

Route::get('booking-by-review/{reviewKey}', BookingByReviewController::class)->name('booking-by-review.show');

Route::apiResource('reviews', ReviewController::class)->only(['show', 'store']);

Route::post('checkout', CheckoutController::class);
