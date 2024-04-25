<?php

namespace App\Imports;

use App\Models\Agunan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AgunanImport implements ToModel, WithChunkReading, SkipsEmptyRows, WithHeadingRow
{
    public function model(array $row)
    {
        DB::table('data_agunan')->where('noreg', $row['noreg'])->delete();

        return new Agunan([
            'noreg'         => $row['noreg'],
            'nokredit'      => $row['nokredit'],
            'agunan'        => $row['agunan'],
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
