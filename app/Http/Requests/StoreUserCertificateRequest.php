<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserCertificateRequest extends FormRequest
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
            'training_id' => 'exists:trainings,id|required',
//            'company_id' => 'exists:companies,id|required',
            'certificate_path' => 'required|file',
            'training_date' => 'before:tomorrow|required',
//            'expiry_date' => 'required',
            'employee_id' => 'exists:employees,id|required|sometimes',

        ];
    }
}
