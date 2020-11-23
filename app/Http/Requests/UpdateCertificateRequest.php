<?php

namespace App\Http\Requests;

use App\Training;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCertificateRequest extends FormRequest
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
            'training_date' => 'date|before:tomorrow|required|sometimes',
            'expiry_date' => 'date|required|sometimes',

        ];
    }
}
