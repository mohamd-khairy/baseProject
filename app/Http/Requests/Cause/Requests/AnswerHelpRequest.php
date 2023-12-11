<?php

namespace App\Http\Requests\Cause\Requests;

use App\Enums\Cause\CauseTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed name
 * @property mixed pages
 */
class AnswerHelpRequest extends FormRequest
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
            'answer' => ['required', 'string']
        ];
    }
}
