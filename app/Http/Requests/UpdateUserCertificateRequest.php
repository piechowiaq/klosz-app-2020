<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserCertificateRequest extends FormRequest
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
            'file' => 'required|sometimes|max:10000|mimes:doc,docx,pdf,jpeg,jpg',
            'training_date' => 'before:tomorrow|required',
            'employee_id' => 'exists:employees,id|required|sometimes',
        ];
    }
}
