<?php

namespace App\Http\Resources\Treatment;

use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'type' => $this->type,
            'name' => $this->name,
            'date' => $this->date,
            'files' => $this->files,
            'formRequest' => $this->formRequest,
            'treatmentInformation' => $this->treatmentInformation,
            'user' => $this->user,
            'department' => $this->department,
            'treatment_action' => [
                'approval_treatment' => $this->approvalTreatment,
                'other_action_data' => $this->treatmentAction
            ],
        ];
    }
}
