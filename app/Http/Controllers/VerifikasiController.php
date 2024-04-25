<?php

namespace App\Http\Controllers;

use App\Models\Agunan;
use App\Models\Penggunaan;
use App\Models\Tugas;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function show($notugas)
    {
        $tugas = Tugas::with('kredit', 'petugas', 'leader', 'verifikasi')->where('notugas', $notugas)->first();
        $tugas->tanggal = Carbon::parse($tugas->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y');
        $tugas->kredit->plafon = 'Rp ' . number_format($tugas->kredit->plafon ?? 0, 0, ',', '.');
        $tugas->foto_pelaksanaan = $tugas->foto_pelaksanaan ?? 'default.png';

        // Penggunaan Kredit
        $penggunaan = Penggunaan::where('no_spk', $tugas->kredit->nospk)->first();

        if (is_null($penggunaan)) {
            if (is_null($tugas->verifikasi->pengguna_kredit)) {
                $tugas->verifikasi->pengguna_kredit = null;
            }

            if (is_null($tugas->verifikasi->penggunaan_kredit)) {
                $tugas->verifikasi->penggunaan_kredit = null;
            }

            if (is_null($tugas->verifikasi->alamat_rumah)) {
                $tugas->verifikasi->alamat_rumah = null;
            }

            if (is_null($tugas->verifikasi->nomor_debitur)) {
                $tugas->verifikasi->nomor_debitur = null;
            }

            $tugas->verifikasi->usaha = "Pekerjaan Debitur";
            $tugas->verifikasi->pendamping = "Nomor Pendamping";
        } else {
            if (is_null($tugas->verifikasi->pengguna_kredit)) {
                $tugas->verifikasi->pengguna_kredit = $tugas->kredit->nama_debitur;
            }

            if (is_null($tugas->verifikasi->penggunaan_kredit)) {
                $tugas->verifikasi->penggunaan_kredit = $penggunaan->keterangan;
            }

            if (is_null($tugas->verifikasi->alamat_rumah)) {
                $tugas->verifikasi->alamat_rumah = $penggunaan->alamat_sekarang;
            }

            if (is_null($tugas->verifikasi->nomor_debitur)) {
                $tugas->verifikasi->nomor_debitur = $penggunaan->nomor_debitur;
            }

            if (is_null($tugas->verifikasi->nomor_pendamping)) {
                if ($penggunaan->produk_kode == 'KPS' || $penggunaan->produk_kode == 'KPJ') {
                    $tugas->verifikasi->nomor_pendamping = $penggunaan->nomor_pendamping;
                } else {
                    $tugas->verifikasi->nomor_pendamping = $penggunaan->nomor_darurat;
                }
            }

            if ($penggunaan->produk_kode == 'KPS' || $penggunaan->produk_kode == 'KPJ') {
                $tugas->verifikasi->usaha = "Pekerjaan Debitur";
                $tugas->verifikasi->pendamping = "Nomor Pendamping";
            } else {
                $tugas->verifikasi->usaha = "Usaha Debitur";
                $tugas->verifikasi->pendamping = "Nomor Darurat";
            }
        }

        $id = Auth::user()->id;
        $tugas->aksesUpload = $tugas->petugas_id == $id ? '' : 'disabled';
        $tugas->aksesLaporan = $tugas->petugas_id == $id ? 'required' : 'readonly';
        $tugas->aksesCatatan = $tugas->leader_id == $id ? 'required' : 'readonly';

        return view('monitoring.verifikasi.show', [
            'tugas' => $tugas,
        ]);
    }

    public function update(Request $request, $notugas)
    {
        if ($request->catatan_leader && is_null($request->karakter_debitur)) {
            $tugas = Tugas::where('notugas', $notugas)->first();
            $tugas->catatan_leader = $request->catatan_leader;
            $tugas->save();
        } else {
            try {
                $client = new Client();
                $response = $client->request('PUT', 'https://simontok.test/api/verifikasi/kredit/' . $notugas, [
                    'form_params' => [
                        'pengguna_kredit'   => $request->pengguna_kredit,
                        'penggunaan_kredit' => $request->penggunaan_kredit,
                        'usaha_debitur'     => $request->usaha_debitur,
                        'cara_pembayaran'   => $request->cara_pembayaran,
                        'alamat_rumah'      => $request->alamat_rumah,
                        'karakter_debitur'  => $request->karakter_debitur,
                        'nomor_debitur'     => $request->nomor_debitur,
                        'nomor_pendamping'  => $request->nomor_pendamping,
                    ],
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ]);

                $data = json_decode($response->getBody()->getContents());

                return redirect()->back()->with('success', 'Tugas berhasil diperbarui');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Tugas tidak boleh kosong');
            }
        }
    }

    public function agunan($notugas)
    {
        $tugas = Tugas::with('petugas', 'leader', 'verifikasi')->where('notugas', $notugas)->first();

        $tugas->tanggal = Carbon::parse($tugas->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y');
        $tugas->kredit->plafon = 'Rp ' . number_format($tugas->kredit->plafon ?? 0, 0, ',', '.');
        $tugas->foto_pelaksanaan = $tugas->foto_pelaksanaan ?? 'default.png';

        $id = Auth::user()->id;
        $tugas->aksesUpload = $tugas->petugas_id == $id ? '' : 'disabled';
        $tugas->aksesLaporan = $tugas->petugas_id == $id ? '' : 'readonly';
        $tugas->aksesCatatan = $tugas->leader_id == $id ? '' : 'readonly';
        $tugas->btnVerifikasi = $tugas->petugas_id == $id ? '' : 'disabled';

        $agunan = Agunan::with('verifikasi')->where('nokredit', $tugas->nokredit)->get();
        $agunan->each(function ($item) {
            $item->tableColor = is_null($item->verifikasi) == '' ? '' : 'table-warning';
            $item->btnColor = is_null($item->verifikasi) == '' ? 'bg-success' : 'bg-warning';
        });

        return view('monitoring.verifikasi.agunan', [
            'tugas' => $tugas,
            'agunan' => $agunan,
        ]);
    }

    public function store_agunan(Request $request, $noreg)
    {
        try {
            $client = new Client();
            $response = $client->request('POST', 'https://simontok.test/api/verifikasi/agunan/' . $noreg, [
                'form_params' => [
                    'notugas'       => $request->notugas,
                    'noreg'         => $noreg,
                    'agunan'        => $request->agunan,
                    'kondisi'       => $request->kondisi,
                    'penguasaan'    => $request->penguasaan,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            return redirect()->back()->with('success', 'Agunan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Agunan tidak boleh kosong');
        }
    }

    public function update_agunan(Request $request, $noreg)
    {
        try {
            $client = new Client();
            $response = $client->request('PUT', 'https://simontok.test/api/verifikasi/agunan/' . $noreg, [
                'form_params' => [
                    'kondisi'       => $request->kondisi,
                    'penguasaan'    => $request->penguasaan,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents());

            return redirect()->back()->with('success', 'Agunan berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Agunan tidak boleh kosong');
        }
    }
}
