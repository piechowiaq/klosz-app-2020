<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTrainingRequest extends FormRequest
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
     * @return array|mixed[]
     */
    public function rules(): array
    {
        return [
            'name' => ['required','sometimes', Rule::unique('trainings', 'name')->ignore($this->training)],
            'description' => 'required|sometimes',
            'valid_for' => 'required|sometimes',
            'position_id' => 'exists:positions,id|required|sometimes',
        ];
    }
}
