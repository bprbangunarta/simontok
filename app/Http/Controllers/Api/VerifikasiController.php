<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateVerifikasiRequest;
use App\Http\Resources\AgunanResource;
use App\Http\Resources\VerifikasiResource;
use App\Models\Agunan;
use App\Models\Tugas;
use App\Models\Verifikasi;
use App\Models\VerifikasiAgunan;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function update(UpdateVerifikasiRequest $request, $notugas)
    {
        $verifikasi = Verifikasi::where('notugas', $notugas)->first();
        $verifikasi->pengguna_kredit     = $request->pengguna_kredit;
        $verifikasi->penggunaan_kredit   = $request->penggunaan_kredit;
        $verifikasi->usaha_debitur       = $request->usaha_debitur;
        $verifikasi->cara_pembayaran     = $request->cara_pembayaran;
        $verifikasi->alamat_rumah        = $request->alamat_rumah;
        $verifikasi->karakter_debitur    = $request->karakter_debitur;
        $verifikasi->nomor_debitur       = $request->nomor_debitur;
        $verifikasi->nomor_pendamping    = $request->nomor_pendamping;
        $verifikasi->save();

        // simpan ke tabel tugas
        $tugas = Tugas::where('notugas', $notugas)->first();
        $tugas->pelaksanaan     = 'Verifikasi Kredit';
        $tugas->ket_pelaksanaan = 'Melakukan Kunjungan ke Rumah Debitur';
        $tugas->hasil           = 'Validasi Data Pengajuan Kredit';
        $tugas->ket_hasil       = 'Pengguna Kredit: ' . $request->pengguna_kredit . ', ' . 'Penggunaan Kredit: ' . $request->penggunaan_kredit . ', ' . 'Usaha Debitur: ' . $request->usaha_debitur . ', ' . 'Karakter Debitur: ' . $request->cara_pembayaran . ', ' . 'Alamat Rumah: ' . $request->alamat_rumah . ', ' . 'Karakter Debitur: ' . $request->karakter_debitur;
        $tugas->status          = 'Selesai';
        $tugas->save();

        return new VerifikasiResource($verifikasi);
    }

    public function store(Request $request, $noreg)
    {
        $request->validate([
            'notugas'    => 'required|unique:data_verifikasi_agunan,notugas',
            'noreg'      => 'required',
            'agunan'     => 'required',
            'kondisi'    => 'required',
            'penguasaan' => 'required',
        ], [
            'notugas.required'      => 'Tugas tidak boleh kosong',
            'notugas.unique'        => 'Tugas sudah digunakan',
            'noreg.required'        => 'Noreg tidak boleh kosong',
            'agunan.required'       => 'Agunan tidak boleh kosong',
            'kondisi.required'      => 'Kondisi tidak boleh kosong',
            'penguasaan.required'   => 'Penguasaan tidak boleh kosong',
        ]);

        $agunan = new VerifikasiAgunan();
        $agunan->notugas     = $request->notugas;
        $agunan->noreg       = $noreg;
        $agunan->agunan      = $request->agunan;
        $agunan->kondisi     = $request->kondisi;
        $agunan->penguasaan  = $request->penguasaan;
        $agunan->save();

        return new AgunanResource($agunan);
    }

    public function agunan(Request $request, $noreg)
    {
        $request->validate([
            'kondisi'    => 'required',
            'penguasaan' => 'required',
        ], [
            'kondisi.required'      => 'Kondisi tidak boleh kosong',
            'penguasaan.required'   => 'Penguasaan tidak boleh kosong',
        ]);

        $agunan = VerifikasiAgunan::where('noreg', $noreg)->first();
        $agunan->kondisi     = $request->kondisi;
        $agunan->penguasaan  = $request->penguasaan;
        $agunan->save();

        return new AgunanResource($agunan);
    }
}
