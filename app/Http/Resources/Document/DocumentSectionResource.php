<?php

namespace App\Http\Resources\Document;

use App\Http\Resources\Global\BasicResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentSectionResource extends JsonResource
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
            'content' => $this->status,
            'status' => $this->status,
            'display_status' => $this->display_status,
            'type' => $this->whenLoaded('type', fn() => new BasicResource($this->type), ['id' => $this->document_secton_type_id]),
            'purpose' => $this->whenLoaded('purpose', fn() => new BasicResource($this->purpose), ['id' => $this->document_purpose_id]),
            'document' => $this->whenLoaded('document', fn() => new DocumentResource($this->sections), ['id'=>$this->document_id]),
            'created_at' => $this->created_at,
        ];
    }
}
