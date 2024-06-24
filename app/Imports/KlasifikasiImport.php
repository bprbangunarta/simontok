<?php

namespace App\Imports;

use App\Models\Klasifikasi;
use App\Models\PendidikanNonFormal;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KlasifikasiImport implements ToCollection, WithHeadingRow, WithChunkReading, SkipsEmptyRows
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $klasifikasi = Klasifikasi::where('nokredit', $row['nokredit'])->first();
            if ($klasifikasi) {
                $klasifikasi->update([
                    'klasifikasi' => $row['klasifikasi'],
                ]);
            }
            // else {
            //     Klasifikasi::create([
            //         'nokredit' => $row['nokredit'],
            //         'nama' => $row['klasifikasi'],
            //     ]);
            // }
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
