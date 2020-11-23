<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTrainingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=> ['required','sometimes', Rule::unique('trainings', 'name')->ignore($this->training)],
            'description'=> 'required|sometimes',
            'valid_for' => 'required|sometimes',
            'position_id' => 'exists:positions,id|required|sometimes',
        ];
    }
}
