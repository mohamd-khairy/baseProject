<?php

namespace App\Http\Resources\Cause\Requests;

use App\Http\Resources\Global\BasicUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HelpRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'questioner' => $this->whenLoaded('questioner', fn() => new BasicUserResource($this->questioner), ['id' => $this->questioner_id]),
            'respondent' => $this->whenLoaded('respondent', fn() => new BasicUserResource($this->respondent), ['id' => $this->respondent_id]),
            'created_at' => $this->created_at,
        ];
    }
}
