<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=> 'required|unique:trainings,name|sometimes',
            'description'=> 'required|sometimes',
            'valid_for' => 'required||sometimes',
            'position_id' => 'exists:positions,id|required|sometimes',
           ];
    }
}
