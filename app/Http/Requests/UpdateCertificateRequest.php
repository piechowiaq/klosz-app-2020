<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCertificateRequest extends FormRequest
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
            'training_id' => 'exists:trainings,id|required|sometimes',
            'company_id' => 'exists:companies,id|required|sometimes',
            'training_date' => 'date|before:tomorrow|required|sometimes',
            'expiry_date' => 'date|required|sometimes',

        ];
    }
}
