<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistryRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=> 'required|unique:registries,name|sometimes',
            'description'=> 'required|sometimes',
            'valid_for' => 'required||sometimes',
        ];
    }
}
