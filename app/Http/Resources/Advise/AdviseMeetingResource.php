<?php

namespace App\Http\Resources\Advise;

use App\Http\Resources\DataEntry\FileResource;
use App\Http\Resources\Global\BasicUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdviseMeetingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'start_at' => $this->start_at,
            'users' => BasicUserResource::collection(User::whereIn('id', $this->users_id)->get()),
            'files' => FileResource::collection($this->files),
            'creator' =>  new BasicUserResource($this->creator)
        ];
    }
}
