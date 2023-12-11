<?php

namespace App\Http\Requests\DataEntry;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
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
            'related_type' => 'nullable|string',
            'related_id' => 'nullable|integer',
            'date' => 'required|date',
            'details' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ];
    }
}
