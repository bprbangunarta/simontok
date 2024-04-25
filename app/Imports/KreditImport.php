<?php

namespace App\Imports;

use App\Models\Kredit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KreditImport implements ToModel, WithChunkReading, SkipsEmptyRows, WithHeadingRow
{
    public function model(array $row)
    {
        DB::table('data_kredit')->where('nokredit', $row['nokredit'])->delete();

        return new Kredit([
            'nocif'             => $row['nocif'],
            'nokredit'          => $row['nokredit'],
            'notabungan'        => $row['notabungan'],
            'nospk'             => $row['nospk'],
            'produk_id'         => $row['produk_id'],
            'nama_debitur'      => $row['nama_debitur'],
            'alamat'            => $row['alamat'],
            'wilayah'           => $row['wilayah'],
            'bidang'            => $row['bidang'],
            'resort'            => $row['resort'],
            'nokaryawan'        => $row['nokaryawan'],
            'plafon'            => $row['plafon'],
            'baki_debet'        => $row['baki_debet'],
            'kolektibilitas'    => $row['kolektibilitas'],
            'metode_rps'        => $row['metode_rps'],
            'jangka_waktu'      => $row['jangka_waktu'],
            'rate_bunga'        => $row['rate_bunga'],
            'tgl_realisasi'     => $row['tgl_realisasi'],
            'tgl_jatuh_tempo'   => $row['tgl_jatuh_tempo'],
            'kode_petugas'      => $row['kode_petugas'],
            'hari_tunggakan'    => $row['hari_tunggakan'],
            'status'            => 1,
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
