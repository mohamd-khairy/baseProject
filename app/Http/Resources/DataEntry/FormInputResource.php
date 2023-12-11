<?php

namespace App\Http\Resources\DataEntry;

use App\Http\Resources\Global\BasicUserResource;
use App\Http\Resources\Global\StageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FormInputResource extends JsonResource
{
    /**
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'label' => $this->label,
            'required' => $this->required,
            'page' => $this->page,
        ];
    }
}
