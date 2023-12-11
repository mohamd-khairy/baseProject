<?php

namespace App\Http\Resources\Advise;

use App\Http\Resources\Global\BasicUserResource;
use App\Models\CauseCompensation;
use App\Models\CauseJudgment;
use App\Models\CauseSession;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdviseLogResource extends JsonResource
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
            'actionable' => $this->whenLoaded('action', fn () => $this->guessActionResource($this->action), null),
            'creator' =>  new BasicUserResource($this->creator),
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

            default => $action,
        };
    }
}
