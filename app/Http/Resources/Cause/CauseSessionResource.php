<?php

namespace App\Http\Resources\Cause;

use App\Http\Resources\Global\BasicResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CauseSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'notes' => $this->notes,
            'type' => $this->type,
            'link' => $this->link,
            'court' => new BasicResource($this->court),
            'file' => $this->file,
            'notified' => (bool)$this->notified,
        ];
    }
}
