<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'number'=> 'required|unique:employees,number|sometimes',
            'company_id'=> 'exists:companies,id|required|sometimes',
            'position_id'=> 'exists:positions,id|required|sometimes',
        ];
    }
}
