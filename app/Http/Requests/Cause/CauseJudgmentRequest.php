<?php

namespace App\Http\Requests\Cause;

use App\Enums\Cause\CauseJudgmentEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed name
 * @property mixed pages
 */
class CauseJudgmentRequest extends FormRequest
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
        return [
            'type' => ['required', Rule::in(CauseJudgmentEnum::getValues())],
            'notes' => ['sometimes', 'nullable', 'string'],
            'judgment_for' => ['required','exists:users,id'],
            'release_date' => 'required|date',
            'receiving_date' => 'sometimes|nullable|date',
            'file' => 'sometimes|nullable|file|mimes:pdf,doc,docx',
        ];
    }
}
