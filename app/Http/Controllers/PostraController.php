<?php

namespace App\Http\Controllers;

use App\Models\Kredit;
use App\Models\Tugas;
use App\Models\Tunggakan;
use App\Models\User;
use App\Models\Verifikasi;
use App\Models\VerifikasiAgunan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostraController extends Controller
{
    public function index()
    {
        $data = Kredit::where('produk_id', '16')
            ->orderBy('nokredit', 'desc');

        $keyword = request('search');
        if (!empty($keyword)) {
            $data->where(function ($query) use ($keyword) {
                $query->where('nokredit', 'like', "%{$keyword}%")
                    ->orWhere('tgl_realisasi', 'like', "%{$keyword}%")
                    ->orWhere('nama_debitur', 'like', "%{$keyword}%");
            });
        }

        $kredit = $data->paginate(10);

        foreach ($kredit as $item) {
            $cekTugas = Tugas::where('nokredit', $item->nokredit)->where('jenis', 'Verifikasi')->first();
            $cekCif = DB::connection('sqlsrv')->table('m_cif')
                ->select('nocif', 'nohp')
                ->where('nocif', $item->nocif)->first();

            $item->tugas = $cekTugas->notugas ?? null;
            $item->nohp = $cekCif->nohp ?? null;
        }

        return view('postra.index', compact('kredit'));
    }

    public function create($nokredit)
    {
        $kredit = Kredit::where('nokredit', $nokredit)->first();

        if (!$kredit) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $agunan = DB::connection('sqlsrv')->table('m_loan_jaminan as a')
            ->select('a.noacc', 'a.noreg', 'b.catatan')
            ->join('m_detil_jaminan as b', 'a.noreg', '=', 'b.noreg')
            ->where('a.noacc', $nokredit)->get();

        foreach ($agunan as $item) {
            $cekAgunan = VerifikasiAgunan::where('noreg', trim($item->noreg))->first();
            $item->penguasaan = $cekAgunan->penguasaan ?? null;
            $item->kondisi = $cekAgunan->kondisi ?? null;
        }

        $nasabah = DB::connection('sqlsrv')->table('m_cif')
            ->select('nocif', 'nohp', 'nofax')
            ->where('nocif', $kredit->nocif)->first();

        return view('postra.create', compact('kredit', 'agunan', 'nasabah'));
    }

    public function store($nokredit, Request $request)
    {
        $request->validate([
            'pengguna_kredit'   => 'required',
            'penggunaan_kredit' => 'required',
            'alamat_rumah'      => 'required',
            'cara_pembayaran'   => 'required',
            'usaha_debitur'     => 'required',
            'karakter_debitur'  => 'required',
            'nomor_debitur'     => 'required',
            'nomor_pendamping'  => 'nullable',
        ], [
            'pengguna_kredit.required'   => 'Pengguna Kredit wajib diisi',
            'penggunaan_kredit.required' => 'Penggunaan Kredit wajib diisi',
            'alamat_rumah.required'      => 'Alamat Rumah wajib diisi',
            'cara_pembayaran.required'   => 'Cara Pembayaran wajib diisi',
            'usaha_debitur.required'     => 'Usaha Debitur wajib diisi',
            'karakter_debitur.required'  => 'Karakter Debitur wajib diisi',
            'nomor_debitur.required'     => 'Nomor Debitur wajib diisi',
        ]);

        try {
            DB::beginTransaction();

            $notugas = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 9));
            $tunggakan = Tunggakan::where('nokredit', $nokredit)->first();

            $leader = User::where('role', 'Kepala Seksi Customer Care')
                ->where('kantor_id', Auth::user()->kantor_id)
                ->where('is_active', 1)
                ->first();

            $dataTugas = [
                'notugas'           => $notugas,
                'nokredit'          => $request->nokredit,
                'tanggal'           => date('Y-m-d'),
                'jenis'             => 'Verifikasi',
                'pelaksanaan'       => 'Verifikasi Kredit',
                'ket_pelaksanaan'   => 'Melakukan verifikasi melalui telepon',
                'hasil'             => 'Validasi Data Pengajuan Kredit',
                'ket_hasil'         => "Pengguna Kredit: {$request->pengguna_kredit}, Penggunaan Kredit: {$request->penggunaan_kredit}, Cara Pembayaran: {$request->cara_pembayaran}, Usaha Debitur: {$request->usaha_debitur}, Karakter Debitur: {$request->karakter_debitur}, Alamat Debitur: {$request->alamat_rumah}",
                'status'            => 'Selesai',
                'tunggakan_pokok'   => $tunggakan->tunggakan_pokok,
                'tunggakan_bunga'   => $tunggakan->tunggakan_bunga,
                'tunggakan_denda'   => $tunggakan->tunggakan_denda,
                'petugas_id'        => Auth::user()->id,
                'leader_id'         => $leader->id,
            ];
            Tugas::create($dataTugas);

            $dataVerifikasi = [
                'notugas'           => $notugas,
                'pengguna_kredit'   => $request->pengguna_kredit,
                'penggunaan_kredit' => $request->penggunaan_kredit,
                'usaha_debitur'     => $request->usaha_debitur,
                'cara_pembayaran'   => $request->cara_pembayaran,
                'alamat_rumah'      => $request->alamat_rumah,
                'karakter_debitur'  => $request->karakter_debitur,
                'nomor_debitur'     => $request->nomor_debitur,
                'nomor_pendamping'  => $request->nomor_pendamping,
            ];
            Verifikasi::create($dataVerifikasi);

            $agunan = DB::connection('sqlsrv')->table('m_loan_jaminan as a')
                ->select('a.noacc', 'a.noreg', 'b.catatan')
                ->join('m_detil_jaminan as b', 'a.noreg', '=', 'b.noreg')
                ->where('a.noacc', $nokredit)
                ->get();

            foreach ($agunan as $item) {
                $dataAgunan = [
                    'notugas'    => $notugas,
                    'noreg'      => trim($item->noreg),
                    'agunan'     => trim($item->catatan),
                    'kondisi'    => null,
                    'penguasaan' => null,
                ];
                VerifikasiAgunan::create($dataAgunan);
            }

            DB::commit();

            return redirect()->route('postra.edit', $notugas)->with('success', 'Verifikasi Kredit berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }

    public function edit($notugas)
    {
        $tugas = Tugas::with('kredit', 'verifikasi')->where('notugas', $notugas)->first();
        if ($tugas->foto_pelaksanaan == null) {
            $tugas->foto_pelaksanaan = Storage::url('uploads/tugas/' . 'default.png');
        } else {
            $tugas->foto_pelaksanaan = Storage::url($tugas->foto_pelaksanaan);
        }

        if (!$tugas) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $agunan = DB::connection('sqlsrv')->table('m_loan_jaminan as a')
            ->select('a.noacc', 'a.noreg', 'b.catatan')
            ->join('m_detil_jaminan as b', 'a.noreg', '=', 'b.noreg')
            ->where('a.noacc', $tugas->kredit->nokredit)->get();

        foreach ($agunan as $item) {
            $cekAgunan = VerifikasiAgunan::where('notugas', $notugas)->where('noreg', trim($item->noreg))->first();
            $item->penguasaan = $cekAgunan->penguasaan ?? null;
            $item->kondisi = $cekAgunan->kondisi ?? null;
        }

        $nasabah = DB::connection('sqlsrv')->table('m_cif')
            ->select('nocif', 'nohp', 'nofax')
            ->where('nocif', $tugas->kredit->nocif)->first();

        return view('postra.edit', compact('tugas', 'agunan', 'nasabah'));
    }

    public function update($notugas, Request $request)
    {
        $request->validate([
            'pengguna_kredit'   => 'required',
            'penggunaan_kredit' => 'required',
            'alamat_rumah'      => 'required',
            'cara_pembayaran'   => 'required',
            'usaha_debitur'     => 'required',
            'karakter_debitur'  => 'required',
            'nomor_debitur'     => 'required',
            'nomor_pendamping'  => 'nullable',
        ], [
            'pengguna_kredit.required'   => 'Pengguna Kredit wajib diisi',
            'penggunaan_kredit.required' => 'Penggunaan Kredit wajib diisi',
            'alamat_rumah.required'      => 'Alamat Rumah wajib diisi',
            'cara_pembayaran.required'   => 'Cara Pembayaran wajib diisi',
            'usaha_debitur.required'     => 'Usaha Debitur wajib diisi',
            'karakter_debitur.required'  => 'Karakter Debitur wajib diisi',
            'nomor_debitur.required'     => 'Nomor Debitur wajib diisi',
        ]);

        $tugas = Tugas::with('kredit', 'verifikasi')->where('notugas', $notugas)->first();

        if (!$tugas) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $notugas = strtoupper(substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyz'), 0, 9));

            $dataVerifikasi = [
                'pengguna_kredit'   => $request->pengguna_kredit,
                'penggunaan_kredit' => $request->penggunaan_kredit,
                'usaha_debitur'     => $request->usaha_debitur,
                'cara_pembayaran'   => $request->cara_pembayaran,
                'alamat_rumah'      => $request->alamat_rumah,
                'karakter_debitur'  => $request->karakter_debitur,
                'nomor_debitur'     => $request->nomor_debitur,
                'nomor_pendamping'  => $request->nomor_pendamping,
            ];
            $tugas->verifikasi()->update($dataVerifikasi);

            $dataTugas = [
                'ket_hasil'         => "Pengguna Kredit: {$request->pengguna_kredit}, Penggunaan Kredit: {$request->penggunaan_kredit}, Cara Pembayaran: {$request->cara_pembayaran}, Usaha Debitur: {$request->usaha_debitur}, Karakter Debitur: {$request->karakter_debitur}, Alamat Debitur: {$request->alamat_rumah}",
                'status'            => 'Selesai',
            ];
            $tugas->update($dataTugas);

            DB::commit();

            return redirect()->back()->with('success', 'Verifikasi Kredit berhasil diubah');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }

    public function updatePhoto($notugas, Request $request)
    {
        $request->validate([
            'foto_pelaksanaan' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'foto_pelaksanaan.required' => 'Foto tidak boleh kosong',
            'foto_pelaksanaan.image'    => 'File harus berupa gambar',
            'foto_pelaksanaan.mimes'    => 'Hanya gambar yang diperbolehkan',
            'foto_pelaksanaan.max'      => 'Ukuran gambar maksimal 2MB',
        ]);

        $tugas = Tugas::with('kredit', 'verifikasi')->where('notugas', $notugas)->first();

        if (!$tugas) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            if ($request->hasFile('foto_pelaksanaan')) {
                if ($tugas->foto_pelaksanaan) {
                    Storage::delete($tugas->foto_pelaksanaan);
                }

                $fotoPath = $request->file('foto_pelaksanaan');
                $foto_pelaksanaan = $fotoPath->storeAs('uploads/tugas', $tugas->notugas . '-' . time() . '.' . $fotoPath->getClientOriginalExtension(), 'public');
            } else {
                $foto_pelaksanaan = $tugas->foto_pelaksanaan;
            }

            $tugas->update([
                'foto_pelaksanaan' => $foto_pelaksanaan,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Foto Pelaksanaan berhasil diubah');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }

    public function updateAgunan($noreg, Request $request)
    {
        $request->validate([
            'penguasaan' => 'required',
            'kondisi'    => 'required',
        ]);

        $agunan = VerifikasiAgunan::where('noreg', $noreg)->first();

        if (!$agunan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        try {
            DB::beginTransaction();

            $dataAgunan = [
                'penguasaan' => $request->penguasaan,
                'kondisi'    => $request->kondisi,
            ];
            $agunan->update($dataAgunan);

            DB::commit();

            return redirect()->back()->with('success', 'Verifikasi Agunan berhasil diubah');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Terjadi kesalahan, silahkan coba lagi');
        }
    }
}
