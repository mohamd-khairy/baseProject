<?php

namespace App\Http\Requests\DataEntry\File;

use Illuminate\Foundation\Http\FormRequest;

class FileChangeRequest extends FormRequest
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
            'path' => $this->request->get('path')
                ? 'file|mimes:pdf,doc,docx'
                : 'sometimes|nullable',
        ];
    }
}
