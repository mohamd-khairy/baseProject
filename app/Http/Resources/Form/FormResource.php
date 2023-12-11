<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
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
            'pages' => $this->pages ? FormPageResource::collection($this->pages) : null
         ];
    }
}
