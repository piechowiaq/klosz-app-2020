<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=> 'required|sometimes',
            'surname'=> 'required|sometimes',
            'email' => ['required','sometimes', Rule::unique('users', 'email')->ignore($this->user)],
            'password'=> 'required|sometimes',
            'role_id' => 'exists:roles,id|required|sometimes',
            'company_id'=> 'exists:companies,id|required|sometimes',
        ];
    }
}
