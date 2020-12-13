<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\User;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
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
    public function rules(Request $request): array
    {
        if (! assert($this->route('user') instanceof User)) {
            throw new Exception('Received user is not the required object');
        }

        return [
            'name' => 'required|sometimes',
            'surname' => 'required|sometimes',
            'email' => ['required','sometimes', Rule::unique('users', 'email')->ignore($this->route('user')->getId())],
            'password' => 'required|sometimes',
            'role_id' => 'exists:roles,id|required|sometimes',
            'company_id' => 'exists:companies,id|required|sometimes',
        ];
    }
}
