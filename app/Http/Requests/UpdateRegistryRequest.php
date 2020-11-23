<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRegistryRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=> ['required','sometimes', Rule::unique('registries', 'name')->ignore($this->registry)],
            'description'=> 'required|sometimes',
            'valid_for' => 'required||sometimes',
        ];
    }
}
