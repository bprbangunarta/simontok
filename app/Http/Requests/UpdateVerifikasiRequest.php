<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVerifikasiRequest extends FormRequest
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
            'pengguna_kredit'       => 'required',
            'penggunaan_kredit'     => 'required',
            'usaha_debitur'         => 'required',
            'cara_pembayaran'       => 'required',
            'alamat_rumah'          => 'required',
            'karakter_debitur'      => 'required',
            'nomor_debitur'         => 'required',
            'nomor_pendamping'      => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'pengguna_kredit.required'      => 'Pengguna Kredit tidak boleh kosong',
            'penggunaan_kredit.required'    => 'Penggunaan Kredit tidak boleh kosong',
            'usaha_debitur.required'        => 'Usaha Debitur tidak boleh kosong',
            'cara_pembayaran.required'      => 'Cara Pembayaran tidak boleh kosong',
            'alamat_rumah.required'         => 'Alamat Rumah tidak boleh kosong',
            'karakter_debitur.required'     => 'Karakter Debitur tidak boleh kosong',
            'nomor_debitur.required'        => 'Nomor Debitur tidak boleh kosong',
            'nomor_pendamping.required'     => 'Nomor Pendamping tidak boleh kosong',
        ];
    }
}
