<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingByReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param $reviewKey
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __invoke($reviewKey, Request $request)
    {
        return Booking::findByReviewKey($reviewKey) ?? abort(Response::HTTP_NOT_FOUND);
    }
}
