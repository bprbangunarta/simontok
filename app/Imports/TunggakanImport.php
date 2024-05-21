<?php

namespace App\Imports;

use App\Models\Tunggakan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TunggakanImport implements ToModel, WithChunkReading, SkipsEmptyRows, WithHeadingRow
{
    public function model(array $row)
    {
        // DB::table('data_tunggakan')->where('nokredit', $row['nokredit'])->delete();
        // DB::table('data_tunggakan')->truncate();

        return new Tunggakan([
            'nokredit'          => $row['nokredit'],
            'tunggakan_pokok'   => $row['tunggakan_pokok'],
            'tunggakan_bunga'   => $row['tunggakan_bunga'],
            'tunggakan_denda'   => $row['tunggakan_denda'],
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
