<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Enums\TreatmentTypeEnum;
use App\Enums\TreatmentStatusEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class TreatmentRequest extends FormRequest
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
        // dd($this->isMethod('put'));
        $rules =  [
            'type' => [new Enum(TreatmentTypeEnum::class)],
            'name' => 'nullable',
            'description' => 'nullable',
            'department_id' => 'nullable|exists:departments,id',
            'user_id' => 'nullable|exists:users,id',
            'advise_id' => 'nullable|required_if:type,consultation|exists:advises,id',
            'treatment_number' => 'nullable|unique:treatments,treatment_number,' . $this->route('treatment'),

        ];
        // For store   method, make 'date' required
        if ($this->isMethod('post')) {
            $rules['date'] = 'required|date';
        } else {
            // For update method, make 'date' optional
            $rules['date'] = 'nullable|date';
        }

        return $rules;
    }
}
