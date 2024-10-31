<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostraController extends Controller
{
    public function index()
    {
        $kredit = DB::connection('sqlsrv')->table('m_loan as a')
            ->select('b.nocif', 'a.noacc', 'b.fname', 'b.alamat', 'b.nohp', 'a.plafond_awal', 'a.tgleff')
            ->join('m_cif as b', 'a.nocif', '=', 'b.nocif')
            ->where('kdprd', '16')->orderBy('noacc', 'desc')->get();

        foreach ($kredit as $item) {
            $cekTugas = Tugas::where('nokredit', $item->noacc)->where('jenis', 'Verifikasi')->count();

            if ($cekTugas == 0) {
                $item->status = false;
            } else {
                $item->status = true;
            }
        }

        return view('postra.index', compact('kredit'));
    }

    public function show($nokredit)
    {
        dd('Hello World Detail');
    }
}
