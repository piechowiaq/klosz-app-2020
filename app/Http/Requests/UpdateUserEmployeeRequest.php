<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserEmployeeRequest extends FormRequest
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
        $companyId = $this->route('company');

        return [
            'name'=> 'sometimes|required',
            'surname'=> 'sometimes|required',
//            'number'=> ['required','sometimes', Rule::unique('employees', 'number')->ignore($this->employee)],

            'number'=> 'unique:employees,number,'.$this->employee->number.',number,company_id,'.$companyId,
//          'company_id'=> 'exists:companies,id|required|sometimes',
            'position_id'=> 'exists:positions,id|required|sometimes',
        ];
    }
}

