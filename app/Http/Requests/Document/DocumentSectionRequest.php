<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class DocumentSectionRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'document_id' => 'required|numeric|exists:documents,id',
            'document_section_type_id' => 'required|numeric|exists:document_types,id',
            'document_section_purpose_id' => 'required|numeric|exists:document_types,id'
        ];
    }
}
