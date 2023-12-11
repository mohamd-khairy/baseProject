<?php

namespace App\Http\Resources\Cause;

use App\Http\Resources\DataEntry\FileResource;
use App\Http\Resources\Global\BasicResource;
use App\Http\Resources\Global\BasicUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CauseResource extends JsonResource
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
            'cause_number' => $this->cause_number,
            'type' => $this->type,
            'date' => $this->date,
            'lawsuit' => $this->lawsuit,
            'lawsuit_file' => $this->lawsuit_file,
            'secret' => $this->secret,
            'status' => $this->status,
            'sub_status' => $this->sub_status,
            'display_status' => $this->display_status,
            'display_sub_status' => $this->display_sub_status,
            'created_at' => $this->created_at,
            'sub_cause_open' => $this->sub_cause_open,
            'sub_causes' => $this->whenLoaded('subCauses', fn() => CauseResource::collection($this->subCauses), []),
            'cause' => $this->whenLoaded('cause', fn() => $this->cause_id ? new CauseResource($this->cause) : [],
                $this->cause_id ? ['id' => $this->cause_id] : []),
            'files' => $this->whenLoaded('files', fn() => FileResource::collection($this->files), []),
            'logs' => $this->whenLoaded('logs', fn() => CauseLogResource::collection($this->logs), []),
            'sessions' => $this->whenLoaded('sessions', fn() => CauseSessionResource::collection($this->sessions), []),
            'judgments' => $this->whenLoaded('judgments', fn() => CauseJudgmentResource::collection($this->judgments), []),
            'compensations' => $this->whenLoaded('compensations', fn() => CauseCompensationResource::collection($this->compensations), []),
            'lastLog' => $this->whenLoaded('lastLog', fn() => new CauseLogResource($this->lastLog), []),
            'teams' => $this->whenLoaded('teams', fn() => BasicUserResource::collection($this->teams), []),
            'assigner' => $this->whenLoaded('assigner', fn() => new BasicUserResource($this->assigner), ['id' => $this->assigner_id]),
            'court' => $this->whenLoaded('court', fn() => new BasicResource($this->court), ['id' => $this->court_id]),
            'department' => $this->whenLoaded('department', fn() => new BasicResource($this->department), ['id' => $this->department_id]),
            'specialization' => $this->whenLoaded('specialization', fn() => new BasicResource($this->specialization), ['id' => $this->specialization_id]),
            'organization' => $this->whenLoaded('organization', fn() => new BasicResource($this->organization), ['id' => $this->organization_id]),
            'claimants' => $this->whenLoaded('claimants', fn() => BasicUserResource::collection($this->claimants), []),
            'defendants' => $this->whenLoaded('defendants', fn() => BasicUserResource::collection($this->defendants), []),
            'fundUsers' => $this->whenLoaded('fundUsers', fn() => BasicUserResource::collection($this->fundUsers), []),
            'creator' => $this->whenLoaded('creator', fn() => new BasicUserResource($this->creator), ['id' => $this->created_by]),
        ];
    }
}
