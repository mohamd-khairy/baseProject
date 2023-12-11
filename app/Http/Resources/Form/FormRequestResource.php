<?php

namespace App\Http\Resources\Form;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormRequestResource extends JsonResource
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
            'status' => $this->status,
            'display_status' => $this->display_status,
            'display_sub_status' => $this->display_sub_status,
            'message' => $this->message,
            'note' => $this->note,
            'form_id' => $this->form_id,
            'user_id' => $this->user_id,
            'category' => $this->category ?? null,
            'department_id' => $this->department_id ?? null,
            'department' => $this->department ?? null,
            'case_type' => $this->case_type,
            'name' => $this->name,
            'form' => new FormResource($this->form),
            'form_page_item_fill' => $this->form_page_item_fill,
            'form_request_informations' => $this->formRequestInformations,
            'user' => $this->user,
            'claimants' => $this->claimants,
            'defendants' => $this->defendants,
            'fundUsers' => $this->fundUsers,
            'lastFormRequestInformation' => $this->lastFormRequestInformation,
            'request' => $this->case,
            'form_request_number' => $this->form_request_number,
            'branch_id' => $this->branch_id,
            'branch' => $this->branch,
            'form_type' => $this->form_type,
            'case_date' => $this->case_date,
            'lawsuit' => $this->lawsuit,
            'specialization_id' => $this->specialization_id,
            'specialization' => $this->specialization,
            'organization_id' => $this->organization_id,
            'organization' => $this->organization,
            'case' => $this->case,
            'file' => $this->file,
            'files' => $this->files,
            'benefire' => $this->benefire,
            'formAssignedRequests' => $this->formAssignedRequests,
            'stage' => $this->stage,
            'secret' => $this->secret,
            'lifeCycles' => $this->lifeCycles
        ];
    }
}
