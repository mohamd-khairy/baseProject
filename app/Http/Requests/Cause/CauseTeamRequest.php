<?php

namespace App\Http\Requests\Cause;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed name
 * @property mixed pages
 */
class CauseTeamRequest extends FormRequest
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
            'assigner_id' => 'required|exists:users,id',
            'teams_id' => 'required|array',
            'teams_id.*' => 'required|exists:users,id',
        ];
    }
}