<?php

namespace App\Http\Requests\DataEntry;

use Illuminate\Foundation\Http\FormRequest;

class FormsRequest extends FormRequest
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
        $data = match ($this->request->get('step')) {
            'base' => [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'type' => 'required|string'
            ],
            'inputs' => [
                'inputs.*.type' => 'required|string',
                'inputs.*.label' => 'required|string',
                'inputs.*.required' => 'required|in:0,1',
                'inputs.*.page' => 'nullable|string'
            ],
            'stages' => [
                'stages.*' => 'required|integer'
            ],
            default => []
        };

        return ['step' => 'required:in:base,inputs,stages'] + $data;
    }
}
