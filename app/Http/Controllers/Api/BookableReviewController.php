<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResource;
use App\Models\Bookable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookableReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function __invoke($id, Request $request): AnonymousResourceCollection
    {
        $bookable = Bookable::findOrFail($id);

        return BookableReviewIndexResource::collection($bookable->reviews()->latest()->get());
    }
}
