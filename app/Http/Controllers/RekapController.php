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
        $search = $request->input('search');
        $tahun  = $search ? Carbon::parse($search)->format('Y') : now()->year;
        $bulan  = $search ? Carbon::parse($search)->format('m') : now()->month;

        $rekap = DB::table('rekap_petugas')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->paginate(10);

        return view('rekap.petugas', compact('rekap'));
    }

    public function show_rekap_petugas($id, $tahun, $bulan)
    {
        $tugas = Tugas::where('petugas_id', $id)
            ->whereNull('pelaksanaan')
            ->where('tanggal', 'like', "$tahun-$bulan%")
            ->get();

        dd($tugas);

        // return response()->json($tugas);
    }

    public function rekap_wilayah(Request $request)
    {
        $search = $request->input('search');
        $tahun  = $search ? Carbon::parse($search)->format('Y') : now()->year;
        $bulan  = $search ? Carbon::parse($search)->format('m') : now()->month;

        $rekap = DB::table('rekap_wilayah')
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->paginate(10);

        return view('rekap.wilayah', compact('rekap'));
    }
}
