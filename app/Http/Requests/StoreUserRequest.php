<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=> 'sometimes|required',
            'surname'=> 'sometimes|required',
            'email' => 'sometimes|required|unique:users',
            'password'=> 'sometimes|required',
            'role_id' => 'sometimes|required',
            'company_id'=> 'sometimes|required',
        ];
    }
}
