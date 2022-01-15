<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookableReviewIndexResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
          'created_at' => $this->created_at,
          'rating' => $this->rating,
          'content' => $this->content
        ];
    }
}
