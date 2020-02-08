<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingRequest extends FormRequest
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
            'name'=> 'required|unique:trainings,name|sometimes',
            'description'=> 'required|sometimes',
            'valid_for' => 'required||sometimes',
            'position_id' => 'exists:positions,id|required|sometimes',
           ];
    }
}
