<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserReportRequest extends FormRequest
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
            'registry_id' => 'exists:registries,id|required|sometimes',
            'company_id' => 'exists:companies,id|required|sometimes',
            'report_path' => 'required|file',
            'report_date' => 'before:tomorrow|required|sometimes',
            'expiry_date' => 'required|sometimes',
        ];
    }
}
