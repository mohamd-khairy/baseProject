<?php

namespace App\Http\Requests\DataEntry;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', 'string', 'min:3', 'max:255',
                Rule::unique('sections')->ignore($this->route('section')),
            ],
            'description' => 'nullable|string',
        ];
    }
}