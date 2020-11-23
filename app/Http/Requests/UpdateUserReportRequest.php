<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserReportRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'registry_id' => 'exists:registries,id|required|sometimes',
            'report_date' => 'before:tomorrow|required|sometimes',
            'file' => 'required|sometimes|max:10000|mimes:doc,docx,pdf,jpeg,jpg'

        ];
    }
}
