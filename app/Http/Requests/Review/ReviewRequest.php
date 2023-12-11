<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'text_before_review' => 'nullable|required_without:file|string',
            'topic_name' => 'required|string',
            'file' => 'nullable|required_without:text_before_review|file|mimes:pdf,doc,docx',
        ];
    }
}
