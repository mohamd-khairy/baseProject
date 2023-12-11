<?php

namespace App\Http\Resources\Global;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasicUserResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "avatar" => $this->avatar,
            "phone" => $this->phone,
            "email" => $this->email,
            'role_name' => $this->roles?->first()?->display_name ?? '---',
            'civil_number' => $this->civil_number,
            'department' => $this->department?->name ?? '---'
        ];
    }
}
