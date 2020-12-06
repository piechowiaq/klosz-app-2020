<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|sometimes',
            'surname' => 'required|sometimes',
            'email' => 'required|unique:users,email|sometimes',
            'password' => 'required|sometimes',
            'role_id' => 'exists:roles,id|required|sometimes',
            'company_id' => 'exists:companies,id|required|sometimes',

        ];
    }
}
