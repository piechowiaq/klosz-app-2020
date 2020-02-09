<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
     * @return array
     */
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
