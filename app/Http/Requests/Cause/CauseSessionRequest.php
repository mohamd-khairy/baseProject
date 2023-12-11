<?php

namespace App\Http\Requests\Cause;

use App\Enums\Cause\CauseJudgmentEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed name
 * @property mixed pages
 */
class CauseSessionRequest extends FormRequest
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
            'date' => 'required|date',
            'notes' => 'nullable|string',
            'court_id' => 'required_if:type,offline',
            'file' => 'sometimes|nullable|file|mimes:pdf,doc,docx',
            'type' => 'required|string|in:online,offline',
            'link' => 'required_if:type,online',
        ];
    }
}