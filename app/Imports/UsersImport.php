<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithChunkReading, SkipsEmptyRows, WithHeadingRow
{
    public function model(array $row)
    {
        DB::table('users')->where('email', $row['email'])->delete();

        $user = new User([
            'name'          => $row['name'],
            'username'      => $row['username'],
            'phone'         => $row['phone'],
            'email'         => $row['email'],
            'role'          => $row['role'],
            'password'      => $row['password'],
            'is_active'     => $row['is_active'],
            'kode'          => $row['kode'],
            'kode_kolektor' => $row['kode_kolektor'],
            'kantor_id'     => $row['kantor_id'],
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now(),
        ]);

        $user->save();
        $user->assignRole($user->role);
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
