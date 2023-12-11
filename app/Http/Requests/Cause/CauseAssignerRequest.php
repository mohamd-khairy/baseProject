<?php

namespace App\Http\Requests\Cause;

use App\Enums\Cause\CauseTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed name
 * @property mixed pages
 */
class CauseAssignerRequest extends FormRequest
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
            'assigner_id' => 'required|exists:users,id',
        ];
    }
}
