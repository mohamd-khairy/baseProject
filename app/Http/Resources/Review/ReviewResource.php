<?php

namespace App\Http\Resources\Review;

use App\Http\Resources\DataEntry\FileResource;
use App\Http\Resources\Global\BasicUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'topic_name' => $this->topic_name,
            'status' => $this->status,
            'text_before_review' => $this->text_before_review,
            'text_after_review' => $this->text_after_review,
            'fileAfterReview' => new FileResource($this->fileAfterReview),
            'fileBeforeReview' => new FileResource($this->fileBeforeReview),
            'user' => new BasicUserResource($this->user),
            'users' => BasicUserResource::collection($this->activeUsers)
        ];
    }
}
