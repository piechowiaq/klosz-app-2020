<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingRequest extends FormRequest
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
            'name' => 'required|unique:trainings,name',
            'description' => 'required',
            'valid_for' => 'required',
            'position_ids' => 'required|array',
            'position_ids.+' => 'exists:positions,id',

        ];
    }
}
