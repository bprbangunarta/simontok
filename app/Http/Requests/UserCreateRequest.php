<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name'          => 'required|string|max:255',
            'username'      => 'required|unique:users,username',
            'phone'         => 'required|unique:users,phone',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6',
            'role'          => 'required',
            'kode'          => 'required|min:3|max:3|unique:users,kode',
            'kode_kolektor' => 'required|min:3|max:3|unique:users,kode_kolektor',
            'kantor_id'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'          => 'Nama tidak boleh kosong',
            'username.required'      => 'Username tidak boleh kosong',
            'username.unique'        => 'Username sudah digunakan',
            'phone.required'         => 'Nomor telepon tidak boleh kosong',
            'phone.unique'           => 'Nomor telepon sudah digunakan',
            'email.required'         => 'Email tidak boleh kosong',
            'email.email'            => 'Email tidak valid',
            'email.unique'           => 'Email sudah digunakan',
            'password.required'      => 'Password tidak boleh kosong',
            'password.min'           => 'Password minimal 6 karakter',
            'role.required'          => 'Role tidak boleh kosong',
            'kode.required'          => 'Kode tidak boleh kosong',
            'kode.min'               => 'Kode minimal 3 karakter',
            'kode.max'               => 'Kode maksimal 3 karakter',
            'kode.unique'            => 'Kode sudah digunakan',
            'kode_kolektor.required' => 'Kode kolektor tidak boleh kosong',
            'kode_kolektor.min'      => 'Kode kolektor minimal 3 karakter',
            'kode_kolektor.max'      => 'Kode kolektor maksimal 3 karakter',
            'kode_kolektor.unique'   => 'Kode kolektor sudah digunakan',
            'kantor_id.required'     => 'Wilayah tidak boleh kosong',
        ];
    }
}
