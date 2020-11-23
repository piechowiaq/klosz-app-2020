<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name'=> 'sometimes|required',
            'surname'=> 'sometimes|required',
            'number'=> ['required','sometimes', Rule::unique('employees', 'number')->ignore($this->employee)],
            'company_id'=> 'exists:companies,id|required|sometimes',
            'position_id'=> 'exists:positions,id|required|sometimes',
        ];
    }
}
