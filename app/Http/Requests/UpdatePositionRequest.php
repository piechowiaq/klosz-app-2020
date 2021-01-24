<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Position;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function assert;

class UpdatePositionRequest extends FormRequest
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
        if (! assert($this->route('position') instanceof Position)) {
            throw new Exception('Received position is not the required object');
        }

        return [
            'name' => ['required','sometimes', Rule::unique('positions', 'name')->ignore($this->route('position')->getId())],
            'department_id' => 'exists:departments,id|required',
        ];
    }
}
