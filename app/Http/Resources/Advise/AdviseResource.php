<?php

namespace App\Http\Resources\Advise;

use App\Http\Resources\DataEntry\FileResource;
use App\Http\Resources\Global\BasicResource;
use App\Http\Resources\Global\BasicUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdviseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'advise_number' => $this->advise_number,
            'work_days' => $this->work_days,
            'date' => $this->date,
            'status' => $this->status,
            'sub_status' => $this->sub_status,
            'survey_status' => $this->survey_status,
            'display_status' => $this->display_status,
            'display_sub_status' => $this->display_sub_status,
            'display_survey_status' => $this->display_survey_status,
            'display_work_days' => $this->display_work_days,
            'meetings' => $this->whenLoaded('meetings', fn () => AdviseMeetingResource::collection($this->meetings), []),
            'surveys' => $this->whenLoaded('surveys', fn () => AdviseServeyResource::collection($this->surveys), []),
            'lastSurvey' => $this->whenLoaded('lastSurvey', fn () => new AdviseServeyResource($this->lastSurvey), null),
            'files' => $this->whenLoaded('files', fn () => FileResource::collection($this->files), []),
            'logs' => $this->whenLoaded('logs', fn () => AdviseLogResource::collection($this->logs), []),
            'lastLog' => $this->whenLoaded('lastLog', fn () => new AdviseLogResource($this->lastLog), null),
            'teams' => $this->whenLoaded('teams', fn () => BasicUserResource::collection($this->teams), []),
            'assigner' => $this->whenLoaded('assigner', fn () => new BasicUserResource($this->assigner), ['id' => $this->assigner_id]),
            'adviseCategory' => $this->whenLoaded('adviseCategory', fn () => new BasicResource($this->adviseCategory), ['id' => $this->advise_category_id]),
            'creator' => $this->whenLoaded('creator', fn () => new BasicUserResource($this->creator), ['id' => $this->created_by]),
            'created_at' => $this->created_at,
            'can_add_survey' => $this->can_add_survey ?? true
        ];
    }
}
