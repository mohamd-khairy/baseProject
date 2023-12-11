<?php

namespace App\Http\Requests\User;

use App\Enums\Global\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $id = $this->user?->id ?? '';

        return [
            'civil_number' => 'nullable|integer|digits:10|unique:users,civil_number,' . $id,
            'phone' => 'nullable|regex:/^[0-9]+$/|digits:10|unique:users,phone,' . $id,

            'password' => 'nullable|min:8|confirmed',
            'name' => 'nullable|string',
            'department_id' => 'sometimes|exists:departments,id',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'avatar' => 'nullable|string',
            'status' => ['sometimes', 'required', Rule::in(...UserTypeEnum::getValues())]
        ];
    }
}
