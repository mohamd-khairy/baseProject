<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
            'assigner_id' => 'nullable|exists:users,id',
            'due_date' => 'nullable|date',
            'details' => 'nullable|string',
            'share_with' => 'nullable|string',
            'taskable_id' => 'nullable|required_with:type',
            'files' => 'nullable|array',
            'files.*' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'stage_id' => 'required|integer',
        ];
    }
}