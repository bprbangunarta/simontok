<?php

namespace App\Exports;

use App\Models\Tugas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

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
