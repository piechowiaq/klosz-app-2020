<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserCertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array|string[]
     */
    public function rules(): array
    {
        return [
            'training_id' => 'exists:trainings,id|required',
            'file' => 'required|sometimes|max:10000|mimes:doc,docx,pdf,jpeg,jpg',
            'training_date' => 'before:tomorrow|required',
            'employee_ids' => 'required|array',
            'employee_ids.+' => 'exists:employees,id',
        ];
    }
}
