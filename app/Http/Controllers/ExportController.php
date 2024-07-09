<?php

namespace App\Http\Controllers;

use App\Exports\JapoExport;
use App\Exports\KlasifikasiKreditExport;
use App\Exports\KreditExport;
use App\Exports\PenangananKreditExport;
use App\Exports\TelebillingExport;
use App\Exports\TugasExport;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function user()
    {
        $fileName = now() . " " . 'USERS.xlsx';
        return Excel::download(new UsersExport, $fileName);
    }

    public function kredit()
    {
        $fileName = date('d_m_Y') . "_" . 'KREDIT.xlsx';
        return Excel::download(new KreditExport, $fileName);
    }

    public function telebilling()
    {
        $fileName = date('d_m_Y') . "_" . 'TELEBILLING.xlsx';
        return Excel::download(new TelebillingExport, $fileName);
    }

    public function japo()
    {
        $fileName = 'JAPO_' . date('Ymd') . '.xlsx';
        return Excel::download(new JapoExport, $fileName);
    }

    public function tugas(Request $request)
    {
        $fileName = 'PENANGANAN_KREDIT_' . date('Ymd') . '.xlsx';
        return Excel::download(new TugasExport(request('start_date'), request('end_date'), request('wilayah'), request('petugas'), request('jenis')), $fileName);
    }

    public function klasifikasi_kredit()
    {
        $fileName = 'klasifikasi kredit' . '.xlsx';
        return Excel::download(new KlasifikasiKreditExport, $fileName);
    }

    public function penanganan_kredit()
    {
        $fileName = 'penanganan kredit' . '.xlsx';
        return Excel::download(new PenangananKreditExport, $fileName);
    }
}
