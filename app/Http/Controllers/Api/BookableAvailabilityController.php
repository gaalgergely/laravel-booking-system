<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookableAvailabilityRequest;
use Symfony\Component\HttpFoundation\Response;

class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, BookableAvailabilityRequest $request)
    {
        $data = $request->validated();

        $bookable = Bookable::findOrFail($id);

        return $bookable->availableFor($data['from'], $data['to'])
            ? response()->json([], Response::HTTP_OK)
            : response()->json([], Response::HTTP_NOT_FOUND);
    }
}
