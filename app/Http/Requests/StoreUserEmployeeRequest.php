<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserEmployeeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $companyId = $this->route('company');

        return [
            'name'=> 'sometimes|required',
            'surname'=> 'sometimes|required',
            'number'=> 'required|unique:employees,number,NULL,id,company_id,'.$companyId,
            'company_id'=> 'exists:companies,id|required|sometimes',
            'position_id'=> 'exists:positions,id|required|sometimes',
        ];
    }
}
