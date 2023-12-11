<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectTaskRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'min:3', 'max:255'],
            'description' => 'nullable|string',
            'project_id' => ['required',  Rule::exists('projects', 'id')],
            'user_id' => ['required', 'array'],
            'user_id.*' => ['required', Rule::exists('users', 'id')],
            'start' => ['nullable'],
            'end' => ['nullable'],
            'project_task_stage_id' => ['required', Rule::exists('project_task_stages', 'id')]
        ];
    }
}
