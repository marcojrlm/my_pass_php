<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userName' => ['required','string', 'min:5'],
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
            'confirmPassword' => 'required|string|same:password|min:8',
            'picture' => 'required|string',
        ];

    }
}
