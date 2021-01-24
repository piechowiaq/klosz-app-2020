<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Company;
use App\Employee;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

use function assert;

class UpdateUserEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array|mixed[]
     *
     * @throws Exception
     */
    public function rules(Request $request): array
    {
        if (! assert($this->route('company') instanceof Company)) {
            throw new Exception('Received company is not the required object');
        }

        if (! assert($this->route('employee') instanceof Employee)) {
            throw new Exception('Received employee is not the required object');
        }

        return [
            'name' => 'sometimes|required',
            'surname' => 'sometimes|required',
            'number' => 'unique:employees,number,' . $this->route('employee')->getNumber() . ',number,company_id,' . $this->route('company')->getId(),
            'position_ids' => 'required|array',
            'position_ids.+' => 'exists:positions,id',
        ];
    }
}
