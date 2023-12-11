<?php

namespace App\Http\Resources\Cause;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CauseCompensationResource extends JsonResource
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
            'id' => $this->id,
            'amount' => $this->amount,
            'loss_percentage' => $this->loss_percentage,
            'notes' => $this->notes,
            'file' => $this->file,
        ];
    }
}
