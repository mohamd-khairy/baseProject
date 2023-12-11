<?php

namespace App\Http\Requests\Contract;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed name
 * @property mixed pages
 */
class ContractMeetingRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'start_at'  => 'required|after:today',
            'users_id' => 'required|array',
            'users_id.*' => 'required|exists:users,id',
            'files' => 'nullable|array',
            'files.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
        ];
    }
}
