<?php

namespace App\Http\Resources\Form;

use App\Http\Resources\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormItemResource extends JsonResource
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
            'name' => $this->name ?? "--",
            'description' => $this->description ?? "--",
            'created_at' => $this->created_at ? $this->created_at->diffForHumans() : 'N/A',
            'updated_at' => $this->updated_at ? $this->updated_at->diffForHumans() : 'N/A',
            'user' => optional($this->user)->name ?? 'Unknown User',
            'pages' => FormPageResource::collection($this->pages),
             'stages' => $this->stages
          ];
    }
}
