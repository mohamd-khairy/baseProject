<?php

namespace App\Http\Resources\Global;

use App\Http\Resources\Cause\Requests\CauseRequestResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
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
            'id' => $this->resource['id'],
            'name' => $this->resource['name'],
            'key' => $this->resource['key'],
            'active' => $this->resource['active'],
            'description' => $this->resource['description'],
            'message' => $this->resource['message'],
            'cause_requests' => CauseRequestResource::collection($this->resource['cause_requests']??[])
        ];
    }
}
