<?php

namespace App\Http\Requests\Cause\Requests;

use App\Enums\Cause\CauseTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed name
 * @property mixed pages
 */
class CauseRequestValidation extends FormRequest
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
            'form_id' => 'required|exists:forms,id',
            'cause_id' => 'required|exists:causes,id',
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx',
            'items.*' => 'required|array',
            'items.*.label' => 'required|string',
            'items.*.type' => 'required|string',
            'items.*.value' => 'required',
        ];
    }
}
