<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Resources\Json\JsonResource;

class FormPageItemResource extends JsonResource
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
            'type' => $this->type,
            'label' => $this->label,
            'notes' => $this->notes,
            'comment' => $this->comment,
            'width' => $this->width,
            'height' => $this->height,
            'enabled' => $this->enabled,
            'required' => $this->required,
            'website_view' => $this->website_view,
            'key' => $this->key,
            'childList' => is_string($this->childList) ? json_decode($this->childList) : $this->childList,
          ];
    }
}
