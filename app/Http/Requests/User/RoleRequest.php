<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
        $id = $this->role?->id ?? '';

        return [
            'name' => "required|unique:roles,name,$id",
            'display_name' => 'required',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,name',
        ];
    }
}
