<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RekapController extends Controller
{
    public function rekap_petugas(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun  = $bulan ? Carbon::parse($bulan)->format('Y') : now()->year;
        $bulan  = $bulan ? Carbon::parse($bulan)->format('m') : now()->month;

        $rekap = DB::table('rekap_petugas')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->get();

        return view('rekap.petugas.index', compact('rekap'));
    }

    public function show_rekap_petugas()
    {
        $id     = request('id');
        $bulan  = request('bulan');
        $tahun  = request('tahun');

        $tanggalAwal = Carbon::create($tahun, $bulan, 1)->toDateString();
        $tanggalAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth()->toDateString();

        $rekap = DB::table('data_tugas')
            ->where('petugas_id', $id)
            ->where('data_tugas.jenis', 'Penagihan')
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->whereNull('pelaksanaan')
            ->get();

        foreach ($rekap as $index => $item) {
            $item->kredit = DB::table('data_kredit')
                ->where('nokredit', $item->nokredit)
                ->first();

            $item->kredit->baki_debet = number_format($item->kredit->baki_debet, 0, ',', '.');

            $item->tunggakan = $item->tunggakan_pokok + $item->tunggakan_bunga + $item->tunggakan_denda;
            $item->tunggakan_pokok = number_format($item->tunggakan_pokok, 0, ',', '.');
        }

        return view('rekap.petugas.show', compact('rekap'));
    }

    public function rekap_wilayah(Request $request)
    {
        $search = $request->input('search');
        $tahun  = $search ? Carbon::parse($search)->format('Y') : now()->year;
        $bulan  = $search ? Carbon::parse($search)->format('m') : now()->month;

        $rekap = DB::table('rekap_wilayah')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->get();

        return view('rekap.wilayah.index', compact('rekap'));
    }

    public function show_rekap_wilayah()
    {
        $wilayah = request('wilayah');
        $bulan   = request('bulan');
        $tahun   = request('tahun');

        $tanggalAwal = Carbon::create($tahun, $bulan, 1)->toDateString();
        $tanggalAkhir = Carbon::create($tahun, $bulan, 1)->endOfMonth()->toDateString();

        $rekap = DB::table('data_tugas')
            ->join('users', 'users.id', '=', 'data_tugas.petugas_id')
            ->join('data_kantor', 'data_kantor.id', '=', 'users.kantor_id')
            ->join('data_kredit', 'data_kredit.nokredit', '=', 'data_tugas.nokredit')
            ->where('users.is_active', true)
            ->where('data_tugas.jenis', 'Penagihan')
            ->where('data_kantor.nama', $wilayah)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->whereNull('pelaksanaan')
            ->get();

        foreach ($rekap as $index => $item) {
            $item->baki_debet = number_format($item->baki_debet, 0, ',', '.');

            $item->tunggakan = $item->tunggakan_pokok + $item->tunggakan_bunga + $item->tunggakan_denda;
            $item->tunggakan_pokok = number_format($item->tunggakan_pokok, 0, ',', '.');
        }

        return view('rekap.wilayah.show', compact('rekap'));
    }

    public function rekap_prospek()
    {
        return view('rekap.prospek.index');
    }
}
