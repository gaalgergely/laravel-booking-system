<?php

namespace App\Http\Controllers\Api;

use App\Bookable;
use App\Http\Resources\Bookable as BookableResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableCollection;
use Illuminate\Http\Request;

class BookableController extends Controller
{
    public function index()
    {
        return new BookableCollection(Bookable::select([

            'id',
            'title',
            'description',
            'price'

        ])->get());
    }

    public function show(Bookable $bookable)
    {
        return new BookableResource($bookable);
    }
}
