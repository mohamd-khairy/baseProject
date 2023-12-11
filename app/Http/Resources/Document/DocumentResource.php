<?php

namespace App\Http\Resources\Document;

use App\Enums\Document\DocumentFileStatusEnum;
use App\Enums\Document\DocumentStatusEnum;
use App\Http\Resources\Global\BasicResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'status' => $this->status,
            'file_status' => $this->file_status,
            'display_status' => DocumentStatusEnum::transValue($this->status),
            'display_file_status' => DocumentFileStatusEnum::transValue($this->file_status),
            'content' => $this->content,
            'type' => $this->whenLoaded('type', fn() => new BasicResource($this->type), ['id' => $this->document_type_id]),
            'classification' => $this->whenLoaded('classification', fn() => new BasicResource($this->classification), ['id' => $this->document_classification_id]),
            'sections' => $this->whenLoaded('sections', fn() => DocumentSectionResource::collection($this->sections), []),
            'created_at' => $this->created_at,
        ];
    }
}
