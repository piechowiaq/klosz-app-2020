<?php

namespace App\Http\Requests;

use App\Position;
use App\Department;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=> 'required|unique:positions,name|sometimes',
            'department_id' => 'exists:departments,id|required|sometimes',
        ];
    }
}
