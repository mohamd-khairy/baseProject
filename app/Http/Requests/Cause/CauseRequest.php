<?php

namespace App\Http\Requests\Cause;

use App\Enums\Cause\CauseTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed name
 * @property mixed pages
 */
class CauseRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $causeId = $this->cause?->id;
        $courtId = $this->request->get('court_id');

        return [
            'name' => 'required|string|max:255',
            'cause_number' => ['required', 'regex:/^[0-9]+$/',
                Rule::unique('causes')->where(function ($query) use ($courtId) {
                    return $query->where('court_id', $courtId);
                })->ignore($causeId),
            ],
            'type' => ['required', Rule::in(CauseTypeEnum::getValues())],
            'date' => 'required|date',
            'lawsuit' => 'nullable|string',
            'lawsuit_file' => ($causeId ? 'sometimes|nullable' : 'required') . $this->request->get('lawsuit_file') ? 'file|mimes:pdf,doc,docx' : '',
            'secret' => 'sometimes|required|in:0,1',
            'specialization_id' => 'required|exists:specializations,id',
            'organization_id' => 'required|exists:organizations,id',
            'assigner_id' => 'nullable|exists:users,id',
            'court_id' => 'required|exists:courts,id',
            'cause_id' => 'nullable|exists:causes,id',
            'claimant_id' => ['required', 'array'],
            'claimant_id.*' => ['required', 'exists:users,id'],
            'defendant_id' => ['required', 'array'],
            'defendant_id.*' => ['required', 'exists:users,id'],
            'fund_user_id' => ['sometimes', 'array'],
            'fund_user_id.*' => ['sometimes', 'exists:users,id'],
            'department_id' => ['required', 'exists:departments,id']
        ];
    }
}
