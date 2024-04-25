<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProspekRequest extends FormRequest
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
            'petugas_id'        => 'required|exists:users,id',
            'tanggal'           => 'required|date',
            'jenis'             => 'required|string',
            'calon_debitur'     => 'required|string',
            'nohp'              => 'nullable|unique:data_prospek,nohp',
            'keterangan'        => 'required|string',
            'foto_pelaksanaan'  => 'nullable|image',
        ];
    }

    public function messages(): array
    {
        return [
            'petugas_id.required'       => 'Petugas harus diisi',
            'petugas_id.exists'         => 'Petugas tidak valid',
            'tanggal.required'          => 'Tanggal harus diisi',
            'tanggal.date'              => 'Tanggal tidak valid',
            'jenis.required'            => 'Jenis harus diisi',
            'jenis.string'              => 'Jenis tidak valid',
            'calon_debitur.required'    => 'Calon Debitur harus diisi',
            'calon_debitur.string'      => 'Calon Debitur tidak valid',
            'nohp.string'               => 'No. HP tidak valid',
            'nohp.unique'               => 'No. HP sudah terdaftar',
            'keterangan.required'       => 'Keterangan harus diisi',
            'keterangan.string'         => 'Keterangan tidak valid',
            'foto_pelaksanaan.image'    => 'Foto Pelaksanaan tidak valid',
        ];
    }
}
