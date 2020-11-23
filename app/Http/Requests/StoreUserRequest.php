<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       return [
            'name'=> 'required|sometimes',
            'surname'=> 'required|sometimes',
            'email' => 'required|unique:users,email|sometimes',
            'password'=> 'required|sometimes',
            'role_id' => 'exists:roles,id|required|sometimes',
            'company_id'=> 'exists:companies,id|required|sometimes',

        ];
    }
}
