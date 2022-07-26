<?php

namespace App\Http\Requests;

use App\Position;
use App\Department;

use Illuminate\Foundation\Http\FormRequest;

class StorePositionRequest extends FormRequest
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
            'name'=> 'required|unique:positions,name|sometimes',
            'department_id' => 'exists:departments,id|required|sometimes',
        ];
    }
}
