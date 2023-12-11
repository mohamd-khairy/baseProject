<?php

namespace App\Http\Requests\Advise;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdviseRequest extends FormRequest
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
            'description' => 'required|string',
            'work_days' => 'nullable',
            'advise_category_id' => 'nullable|exists:advise_categories,id',
            'assigner_id' => 'nullable|exists:users,id',
            'files' => 'nullable|array',
            'files.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ];
    }
}
