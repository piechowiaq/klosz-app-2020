<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Company;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function assert;

class UpdateCompanyRequest extends FormRequest
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
        if (! assert($this->route('company') instanceof Company)) {
            throw new Exception('Received company is not the required object');
        }

        return [
            'name' => ['required', Rule::unique('companies', 'name')->ignore($this->route('company')->getId())],
            'department_id' => 'sometimes|array',
            'department_id.+' => 'exists:departments,id',
            'registry_id' => 'sometimes|array',
            'registry_id.+' => 'exists:registries,id',
        ];
    }
}
