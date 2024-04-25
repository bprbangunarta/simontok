<?php

namespace App\Exports;

use App\Models\Kantor;
use App\Models\Kredit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class KreditExport implements FromView
{
    public function view(): View
    {
        $kode   = Auth::user()->kode;
        $role   = Auth::user()->role;
        $kantor = Kantor::find(Auth::user()->kantor_id);

        $data = Kredit::with('tunggakan', 'petugas');

        if ($role == 'Kepala Seksi Kredit') {
            $data->where('wilayah', $kantor->nama)
                ->whereNotIn('bidang', ['REMEDIAL']);
        } elseif ($role == 'Kepala Seksi Remedial') {
            $data->where('bidang', 'REMEDIAL');
        } elseif ($role == 'AO Kredit' || $role == 'Staff Remedial') {
            $data->where('kode_petugas', $kode);
        }

        $kredit = $data->orderBy('hari_tunggakan', 'desc')->get();

        return view('exports.kredit', [
            'kredit' => $kredit,
        ]);
    }
}
