<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Department;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function assert;

class UpdateDepartmentRequest extends FormRequest
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
        if (! assert($this->route('department') instanceof Department)) {
            throw new Exception('Received department is not the required object');
        }

        return ['name' => ['required', Rule::unique('departments', 'name')->ignore($this->route('department')->getId())]];
    }
}
