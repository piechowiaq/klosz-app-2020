<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Registry;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function assert;

class UpdateRegistryRequest extends FormRequest
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
        if (! assert($this->route('registry') instanceof Registry)) {
            throw new Exception('Received registry is not the required object');
        }

        return [
            'name' => ['required','sometimes', Rule::unique('registries', 'name')->ignore($this->route('registry')->getId())],
            'description' => 'required|sometimes',
            'valid_for' => 'required||sometimes',
        ];
    }
}
