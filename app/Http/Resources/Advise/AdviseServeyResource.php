<?php

namespace App\Http\Resources\Advise;

use App\Http\Resources\Global\BasicUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdviseServeyResource extends JsonResource
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
            'details' => $this->details,
            'file' => $this->file,
            'assigner_id' => $this->assigner_id,
            'date' => $this->created_at,
            'action_date' => $this->action_date,
            'status' => $this->status,
            'notes' => AdviseLogResource::collection($this->actions),
            'display_status' => $this->display_status,
            'display_survey_work_days' => $this->display_survey_work_days,
            'assigner' =>  new BasicUserResource($this->assigner),
        ];
    }
}
