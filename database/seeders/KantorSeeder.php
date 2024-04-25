<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KantorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kantors = [
            ['kode' => 'CGK', 'nama' => 'Jalancagak'],
            ['kode' => 'KJT', 'nama' => 'Kalijati'],
            ['kode' => 'PGD', 'nama' => 'Pagaden'],
            ['kode' => 'PMK', 'nama' => 'Pamanukan'],
            ['kode' => 'PSK', 'nama' => 'Pusakajaya'],
            ['kode' => 'SBG', 'nama' => 'Subang'],
            ['kode' => 'SKM', 'nama' => 'Sukamandi'],
            ['kode' => 'RMD', 'nama' => 'Remedial'],
            ['kode' => 'PST', 'nama' => 'Pusat'],
        ];

        foreach ($kantors as $kantor) {
            \App\Models\Kantor::create($kantor);
        }
    }
}
