<?php

namespace App\Http\Resources\Cause;

use App\Http\Resources\Cause\Requests\CauseRequestResource;
use App\Http\Resources\Global\BasicUserResource;
use App\Models\CauseCompensation;
use App\Models\CauseJudgment;
use App\Models\CauseRequest;
use App\Models\CauseSession;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CauseLogResource extends JsonResource
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
            'notes' => $this->notes,
            'type' => $this->type,
            'display_type' => $this->display_type,
            'actionable' => $this->whenLoaded('action', fn() => $this->guessActionResource($this->action), []),
            'creator' => $this->whenLoaded('creator', fn() => new BasicUserResource($this->creator), ['id' => $this->created_by]),
            'date' => $this->created_at,
        ];
    }

    /**
     * @param mixed $action
     * @return mixed
     */
    protected function guessActionResource(mixed $action): mixed
    {
        return match (true) {
            $action instanceof CauseSession => new CauseSessionResource($action),
            $action instanceof CauseJudgment => new CauseJudgmentResource($action),
            $action instanceof CauseCompensation => new CauseCompensationResource($action),
            $action instanceof CauseRequest => new CauseRequestResource($action),
            default => [],
        };
    }
}
