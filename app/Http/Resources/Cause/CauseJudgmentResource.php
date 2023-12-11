<?php

namespace App\Http\Resources\Cause;

use App\Enums\Cause\CauseJudgmentEnum;
use App\Http\Resources\Global\BasicUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class CauseJudgmentResource extends JsonResource
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
            'id' =>$this->id,
            'type' => $this->type,
            'display_type' => CauseJudgmentEnum::transValue($this->type),
            'notes' => $this->notes,
            'file' => $this->file,
            'release_date' => $this->release_date->format('Y-m-d'),
            'receiving_date' => $this->receiving_date?->format('Y-m-d'),
            'judgment_for' => new BasicUserResource($this->judgmentFor),
        ];
    }
}