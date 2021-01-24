<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Training;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function assert;

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
     *
     * @throws Exception
     */
    public function rules(): array
    {
        if (! assert($this->route('training') instanceof Training)) {
            throw new Exception('Received training is not the required object');
        }

        return [
            'name' => ['required', Rule::unique('trainings', 'name')->ignore($this->route('training')->getId())],
            'description' => 'required',
            'valid_for' => 'required',
            'position_ids' => 'required|array',
            'position_ids.+' => 'exists:positions,id',
        ];
    }
}
