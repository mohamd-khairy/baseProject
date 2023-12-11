<?php

namespace App\Http\Resources\DataEntry;

use App\Http\Resources\Global\BasicUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'name' => $this->name,
            'path' => $this->path,
            'status' => (bool)$this->status,
            'priority' => $this->priority,
            'type' => $this->type,
            'created_at' => $this->created_at,
            'fileable' => $this->whenLoaded('fileable', fn() => $this->fileable, []),
            'creator' => $this->whenLoaded('creator', fn() => new BasicUserResource($this->creator), ['id' => $this->created_by]),
        ];
    }
}
