<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Company;
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

        return [
            'name' => 'sometimes|required',
            'surname' => 'sometimes|required',
            'number' => 'unique:employees,number,' . $request->get('number') . ',number,company_id,' . $this->route('company')->getId(),
            'position_id' => 'exists:positions,id|required|sometimes',
        ];
    }
}
