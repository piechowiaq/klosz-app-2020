<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserCertificateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'training_id' => 'exists:trainings,id|required',
            'file' => 'required|sometimes|max:10000|mimes:doc,docx,pdf,jpeg,jpg',
            'training_date' => 'before:tomorrow|required',
            'employee_id' => 'exists:employees,id|required|sometimes',
        ];
    }
}
