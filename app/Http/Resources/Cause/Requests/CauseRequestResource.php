<?php

namespace App\Http\Resources\Cause\Requests;

use App\Http\Resources\Cause\CauseLogResource;
use App\Http\Resources\Cause\CauseResource;
use App\Http\Resources\Global\BasicUserResource;
use App\Http\Resources\Global\StageResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CauseRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'file' => $this->file,
            'details' => &$details,
            'form_id' => $this->form_id,
            'helpRequests' => $this->whenLoaded('helpRequests', fn() => HelpRequestResource::collection($this->helpRequests), []),
            'stage' => $this->whenLoaded('stage', fn() => new StageResource($this->stage),['id' => $this->stage_id]),
            'causeLogs' => $this->whenLoaded('causeLogs', fn() => CauseLogResource::collection($this->causeLogs), []),
            'logs' => $this->whenLoaded('logs', fn() => CauseLogResource::collection($this->logs), []),
            'lifeCycles' => $this->whenLoaded('lifeCycles', fn() => CauseRequestLifeCycleResource::collection($this->lifeCycles), []),
            'cause' => $this->whenLoaded('cause', fn() => new CauseResource($this->cause), ['id' => $this->cause_id]),
            'creator' => $this->whenLoaded('creator', fn() => new BasicUserResource($this->creator), ['id' => $this->created_by]),
            'reviewer' => $this->whenLoaded('reviewer', fn() => new BasicUserResource($this->reviewer), ['id' => $this->reviewer_id]),
            'created_at' => $this->created_at,
        ];

        if (!empty($this->values)) {
            $details = $this->values->map(fn($value) => [
                'id' => $value->id,
                'label' => $value->label,
                'value' => $value->value,
                'type' => $value->type
            ]);
        }

        return $data;
    }

}
