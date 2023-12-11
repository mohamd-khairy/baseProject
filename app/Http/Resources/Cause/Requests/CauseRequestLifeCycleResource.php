<?php

namespace App\Http\Resources\Cause\Requests;

use App\Http\Resources\Global\BasicUserResource;
use App\Http\Resources\Global\StageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CauseRequestLifeCycleResource extends JsonResource
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
            'from_stage' => new StageResource($this->fromStage),
            'to_stage' =>  new StageResource($this->toStage),
            'notes' => $this->notes,
            'creator' =>  new BasicUserResource($this->creator),
            'created_at' => $this->created_at,
        ];
    }
}