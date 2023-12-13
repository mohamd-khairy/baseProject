<?php

namespace App\Http\Resources\Global;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    /***
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /***
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'page' => 'nullable|numeric|min:1',
        ];
    }
}
