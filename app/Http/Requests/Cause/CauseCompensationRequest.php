<?php

namespace App\Http\Requests\Cause;

use App\Enums\Cause\CauseJudgmentEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed name
 * @property mixed pages
 */
class CauseCompensationRequest extends FormRequest
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
            'amount' => 'required',
            'loss_percentage' => 'required',
            'notes' => 'nullable|string',
            'file' => 'sometimes|nullable|file|mimes:pdf,doc,docx',
        ];
    }
}