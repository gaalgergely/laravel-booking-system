<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewRequest;
use App\Review;
use App\Http\Resources\Review as ReviewResource;
use Symfony\Component\HttpFoundation\Response;

class ReviewController extends Controller
{
    public function show($id)
    {
        return new ReviewResource(Review::findOrFail($id));
    }

    public function store(ReviewRequest $request)
    {
        $request = $request->validated();

        $booking = Booking::findByReviewKey($request['id']);

        if ($booking === null) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        $booking->review_key = '';
        $booking->save();

        $review = Review::make($request);
        $review->booking_id = $booking->id;
        $review->bookable_id = $booking->bookable_id;
        $review->save();

        return new ReviewResource($review);
    }
}
