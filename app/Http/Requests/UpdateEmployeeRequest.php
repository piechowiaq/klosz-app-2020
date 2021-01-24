<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Employee;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function assert;

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
     *
     * @throws Exception
     */
    public function rules(): array
    {
        if (! assert($this->route('employee') instanceof Employee)) {
            throw new Exception('Received employee is not the required object');
        }

        return [
            'name' => 'sometimes|required',
            'surname' => 'sometimes|required',
            'number' => ['required','sometimes', Rule::unique('employees', 'number')->ignore($this->route('employee')->getId())],
            'company_id' => 'exists:companies,id|required|sometimes',
            'position_id' => 'exists:positions,id|required|sometimes',
        ];
    }
}
