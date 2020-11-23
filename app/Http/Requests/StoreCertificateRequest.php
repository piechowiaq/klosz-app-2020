<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'training_id' => 'exists:trainings,id|required|sometimes',
            'company_id' => 'exists:companies,id|required|sometimes',
            'training_date' => 'before:tomorrow|required|sometimes',
            'expiry_date' => 'required|sometimes',

        ];
    }
}
