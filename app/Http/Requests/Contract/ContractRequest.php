<?php

namespace App\Http\Requests\Contract;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContractRequest extends FormRequest
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
        $adviseId = $this->advise?->id;

        return [
            'name' => 'required|string|max:255',
            'work_days' => 'nullable',
            'contract_category_id' => 'nullable|exists:contract_categories,id',
            'assigner_id' => 'nullable|exists:users,id',
            'files' => 'nullable|array',
            'files.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ];
    }
}
