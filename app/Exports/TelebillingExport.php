<?php

namespace App\Exports;

use App\Models\Kantor;
use App\Models\Kredit;
use App\Models\Tugas;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Str;

class TelebillingExport implements FromView
{
    public function view(): View
    {
        $tugas = Tugas::with('kredit', 'kredit.tunggakan', 'kredit.petugas')
            ->where('jenis', 'Telebilling')
            ->where('tanggal', date('Y-m-d'))
            ->get();

        return view('exports.telebilling', [
            'tugas' => $tugas,
        ]);
    }
}
