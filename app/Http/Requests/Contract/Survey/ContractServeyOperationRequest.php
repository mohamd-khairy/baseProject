<?php

namespace App\Http\Requests\Contract\Survey;

use App\Enums\Contract\ContractSurveyStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContractServeyOperationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(ContractSurveyStatusEnum::getValues())],
            'notes' => ['nullable'],
            'assigner_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
