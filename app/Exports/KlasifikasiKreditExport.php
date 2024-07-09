<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class KlasifikasiKreditExport implements FromView
{
    public function view(): View
    {
        $kredit = DB::table('klasifikasi_kredit')->get();

        return view('exports.klasifikasi-kredit', [
            'kredit' => $kredit,
        ]);
    }
}
