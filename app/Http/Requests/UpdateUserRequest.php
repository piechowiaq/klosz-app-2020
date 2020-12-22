<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\User;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

use function assert;

class UpdateUserRequest extends FormRequest
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
        if (! assert($this->route('user') instanceof User)) {
            throw new Exception('Received user is not the required object');
        }

        return [
            'name' => 'required',
            'surname' => 'required',
            'email' => ['required', Rule::unique('users', 'email')->ignore($this->route('user')->getId())],
            'password' => 'required',
            'role_id' => 'exists:roles,id|required',
            'company_id' => 'exists:companies,id|required',
        ];
    }
}
