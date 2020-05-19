<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Bookable;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/bookables', function () {
    return Bookable::all();
});

Route::get('/bookables/{id}', function ($id) {
    return Bookable::findOrFail($id);
});
