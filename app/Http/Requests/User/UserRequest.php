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
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'phone' => 'nullable|regex:/^[0-9]+$/|digits:11|unique:users,phone,' . $id,
            'avatar' => 'nullable|image',
            'roles' => 'required_if:' . request()->method() . ',POST|array',
            'roles.*' => 'required|exists:roles,name'
        ];
    }
}
