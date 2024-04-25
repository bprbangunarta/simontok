<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name'     => 'required',
            'username' => 'required|unique:users,username,' . auth()->id(),
            'phone'    => 'required|unique:users,phone,' . auth()->id(),
            'email'    => 'required|email|unique:users,email,' . auth()->id(),
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama tidak boleh kosong',
            'username.required' => 'Username tidak boleh kosong',
            'username.unique'   => 'Username sudah digunakan',
            'phone.required'    => 'Nomor telepon tidak boleh kosong',
            'phone.integer'     => 'Nomor telepon harus berupa angka',
            'phone.unique'      => 'Nomor telepon sudah digunakan',
            'email.required'    => 'Email tidak boleh kosong',
            'email.email'       => 'Email tidak valid',
            'email.unique'      => 'Email sudah digunakan',
        ];
    }
}
