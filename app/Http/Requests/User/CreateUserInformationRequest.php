<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserInformationRequest extends FormRequest
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
            'civil_number' => 'required|integer|unique:user_information|digits:10',
            'name' => 'required',
            'phone' => 'nullable|unique:users|digits:10|regex:/^[0-9]+$/',
            'email' => 'nullable|email|unique:users',
            'department_id' => 'nullable|exists:departments,id',
        ];
    }
}
