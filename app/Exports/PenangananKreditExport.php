<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PenangananKreditExport implements FromView
{
    public function view(): View
    {
        $kredit = DB::table('penanganan_kredit')->get();

        return view('exports.penanganan-kredit', [
            'kredit' => $kredit,
        ]);
    }
}
