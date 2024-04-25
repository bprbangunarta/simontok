<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePasswordRequest extends FormRequest
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
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Kata sandi saat ini diperlukan',
            'password.required'         => 'Kata sandi baru diperlukan',
            'password.min'              => 'Kata sandi baru minimal 6 karakter',
            'password.confirmed'        => 'Konfirmasi kata sandi tidak cocok',
        ];
    }
}
