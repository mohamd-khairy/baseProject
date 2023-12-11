<?php

namespace App\Http\Requests\Treatment;

use Illuminate\Foundation\Http\FormRequest;

class TreatmentInformationRequest extends FormRequest
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

    public function rules()
    {
        $rules = [
            'treatment_id' => 'required|exists:treatments,id',
            'date' => 'required|date',
        ];

        $data = $this->all();

        foreach ($data as $key => $value) {
            if ($key !== 'treatment_id' && $key !== 'date') {
                $rules[$key] = 'nullable|string';
            }
        }

        return $rules;
    }
}
