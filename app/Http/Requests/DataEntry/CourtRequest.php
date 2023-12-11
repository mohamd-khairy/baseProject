<?php

namespace App\Http\Requests\DataEntry;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourtRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'sometimes', 'required', 'string', 'min:3', 'max:255',
                Rule::unique('courts')->ignore($this->route('court')),
            ],
            'description' => 'sometimes|nullable|string',
        ];
    }
}
