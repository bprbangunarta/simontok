<?php

namespace App\Imports;

use App\Models\Kredit;
use App\Models\Tunggakan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TunggakanImport implements ToCollection, WithHeadingRow, WithChunkReading, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Tunggakan::where('nokredit', $row['nokredit'])
                ->update([
                    'tunggakan_pokok'   => $row['tunggakan_pokok'],
                    'tunggakan_bunga'   => $row['tunggakan_bunga'],
                    'tunggakan_denda'   => $row['tunggakan_denda'],
                    'hari_tunggakan'    => $row['hari_tunggakan'],
                ]);

            Kredit::where('nokredit', $row['nokredit'])
                ->update([
                    'hari_tunggakan'    => $row['hari_tunggakan'],
                ]);
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
