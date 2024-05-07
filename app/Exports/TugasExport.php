<?php

namespace App\Exports;

use App\Models\Tugas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TugasExport implements FromView
{
    protected $startDate;
    protected $endDate;
    protected $wilayah;
    protected $petugas;
    protected $jenis;

    public function __construct($startDate, $endDate, $wilayah, $petugas, $jenis)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->wilayah = $wilayah;
        $this->petugas = $petugas;
        $this->jenis = $jenis;
    }

    public function view(): View
    {
        $data = Tugas::with('kredit', 'writeoff', 'petugas')
            ->whereBetween('tanggal', [$this->startDate, $this->endDate]);

        if ($this->wilayah) {
            if ($this->wilayah == 'Remedial') {
                $data->whereHas('kredit', function ($query) {
                    $query->where('bidang', $this->wilayah);
                });
            } else {
                $data->whereHas('kredit', function ($query) {
                    $query->where('wilayah', $this->wilayah)->whereNot('bidang', 'Remedial');
                });
            }
        }

        if ($this->petugas) {
            $data->where('petugas_id', $this->petugas);
        }

        if ($this->jenis) {
            if ($this->jenis == 'Telebilling') {
                $data->where('jenis',  $this->jenis);
            } else {
                $data->where('jenis', '!=', 'Telebilling');
            }
        }

        $tugas = $data->get();

        $tugas->each(function ($item) {
            if (is_null($item->kredit)) {
                $item->nama_debitur = optional($item->writeoff)->nama_debitur;
                $item->nokredit = optional($item->writeoff)->nokredit;
            } else {
                $item->nama_debitur = optional($item->kredit)->nama_debitur;
                $item->nokredit = optional($item->kredit)->nokredit;
            }

            if (is_null($item->foto_pelaksanaan)) {
                $item->foto_pelaksanaan = ENV('APP_URL') . '/storage/uploads/tugas/default.png';
            } else {
                $item->foto_pelaksanaan = ENV('APP_URL') . '/storage/uploads/tugas/' . $item->foto_pelaksanaan;
            }
        });

        return view('exports.tugas', [
            'tugas' => $tugas,
        ]);
    }
}
