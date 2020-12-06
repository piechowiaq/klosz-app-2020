<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array|string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required',
            'surname' => 'sometimes|required',
            'number' => 'required|unique:employees,number,NULL,id,company_id,' . $this->route('company')->getId(),
            'company_id' => 'exists:companies,id|required|sometimes',
            'position_id' => 'exists:positions,id|required|sometimes',
        ];
    }
}
