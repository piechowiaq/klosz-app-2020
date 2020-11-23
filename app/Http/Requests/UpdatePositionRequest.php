<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePositionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required','sometimes', Rule::unique('positions', 'name')->ignore($this->position)],
            'department_id' => 'exists:departments,id|required|sometimes',
        ];
    }
}
