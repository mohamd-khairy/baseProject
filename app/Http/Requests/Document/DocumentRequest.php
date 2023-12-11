<?php

namespace App\Http\Requests\Document;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|min:3|max:255',
            'document_type_id' => 'required|numeric|exists:document_types,id',
            'document_classification_id' => 'sometimes|required|numeric|exists:document_classifications,id'
        ];

        if (!$this->isMethod('put') && !$this->isMethod('patch')) {
            $rules['path'] = 'required|file|mimes:pdf';
        }

        return $rules;
    }
}
