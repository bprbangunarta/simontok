<?php

namespace App\Exports;

use App\Models\Cif;
use App\Models\Kantor;
use App\Models\Kredit;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class JapoExport implements FromView
{
    public function view(): View
    {
        $today = date('d');
        $tomorrow = date('d', strtotime('+1 day'));
        $dayAfterTomorrow = date('d', strtotime('+2 days'));

        $kredit = Kredit::whereNotIn('produk_id', ['7', '10', '14'])
            ->whereRaw("DAY(tgl_jatuh_tempo) IN ('$today', '$tomorrow', '$dayAfterTomorrow')")
            ->orderByRaw("DAY(tgl_jatuh_tempo) ASC")
            ->get();


        $kredit->each(function ($item) {
            $cif = Cif::where('nocif', $item->nocif)->first();
            $item->nohp = $cif->nohp ?? '0';
            // $item->nohp = substr($item->nohp, 0, 1) == '0' ? '62' . substr($item->nohp, 1) : $item->nohp;
            // $item->nohp = (string)$item->nohp;

            $item->tanggal = date('d', strtotime($item->tgl_jatuh_tempo));
            $item->bulan = date('m');
            $item->tahun = date('Y');
            $item->tgl_jatuh_tempo = Carbon::createFromDate($item->tahun, $item->bulan, $item->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y');
        });

        // dd($kredit->toArray());

        return view('exports.japo', [
            'kredit' => $kredit,
        ]);
    }
}
