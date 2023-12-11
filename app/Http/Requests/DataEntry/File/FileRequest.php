<?php

namespace App\Http\Requests\DataEntry\File;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1', // Enum values
            'priority' => 'required', // Enum values
            'path' => 'required|file|mimes:pdf,doc,docx',
            'fileable_id' => 'required|numeric',
        ];
    }
}
