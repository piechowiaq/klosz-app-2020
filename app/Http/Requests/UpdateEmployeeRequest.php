<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
     * @return array|mixed[]
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required',
            'surname' => 'sometimes|required',
            'number' => ['required','sometimes', Rule::unique('employees', 'number')->ignore($this->employee)],
            'company_id' => 'exists:companies,id|required|sometimes',
            'position_id' => 'exists:positions,id|required|sometimes',
        ];
    }
}
