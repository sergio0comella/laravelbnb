<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookableIndexResource;
use App\Http\Resources\BookableShowResource;
use Illuminate\Http\Request;
use App\Models\Bookable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookableController extends Controller
{

    public function index(): AnonymousResourceCollection
    {
        return BookableIndexResource::collection(Bookable::all());
    }

    public function show($id): BookableShowResource
    {
        return new BookableShowResource(Bookable::findOrFail($id));
    }
}
