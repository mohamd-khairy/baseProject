<?php

namespace App\Http\Resources\DataEntry;

use App\Http\Resources\Global\BasicUserResource;
use App\Http\Resources\Global\StageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'inputs' => $this->whenLoaded('inputs', fn() => FormInputResource::collection($this->inputs), []),
            'stages' =>$this->whenLoaded('stages', fn() => StageResource::collection($this->stages), []),
            'created_at' => $this->created_at,
            'creator' => $this->whenLoaded('creator', fn() => new BasicUserResource($this->creator), ['id' => $this->created_by]),
        ];
    }
}
