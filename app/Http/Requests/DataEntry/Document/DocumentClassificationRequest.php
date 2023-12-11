<?php

namespace App\Http\Requests\DataEntry\Document;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentClassificationRequest extends FormRequest
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
                Rule::unique('document_classifications')->ignore($this->route('document_classification')),
            ],
            'description' => 'nullable|string',
        ];
    }
}
