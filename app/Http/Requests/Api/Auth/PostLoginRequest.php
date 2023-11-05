<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PostLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>|\Illuminate\Contracts\Validation\ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'cpf' => [
                'required',
            ],
            'password' => [
                'required',
            ],
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @param null|array<int, null|int|string>|mixed $keys
     *
     * @return array<int|string,mixed>
     */
    public function all($keys = null)
    {
        $cpf = $this->get('cpf');

        if (is_string($cpf)) {
            return array_merge(
                parent::all($keys),
                ['cpf' => strtolower($cpf)]
            );
        }

        return parent::all($keys);
    }
}
