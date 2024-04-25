<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTugasRequest extends FormRequest
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
            'pelaksanaan'       => 'nullable',
            'ket_pelaksanaan'   => 'nullable',
            'hasil'             => 'nullable',
            'ket_hasil'         => 'nullable',
            'catatan_leader'    => 'nullable',
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'pelaksanaan.required'      => 'Pelaksanaan tidak boleh kosong',
    //         'ket_pelaksanaan.required'  => 'Keterangan pelaksanaan tidak boleh kosong',
    //         'hasil.required'            => 'Hasil tidak boleh kosong',
    //         'ket_hasil.required'        => 'Keterangan hasil tidak boleh kosong',
    //     ];
    // }
}
