<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingByReviewShowResource;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingByReviewController extends Controller
{

    /**
     * @param $reviewKey
     * @param Request $request
     * @return BookingByReviewShowResource
     */
    public function __invoke($reviewKey, Request $request)
    {
        //?? operator se a sinistra hai null restituisce quello a destra
        $booking = Booking::findByReviewKey($reviewKey);
        return $booking ? new BookingByReviewShowResource($booking) : abort(404);
    }
}
