<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $sa = User::factory()->create([
                'name'          => 'Zulfadli Rizal',
                'username'      => 'zulfame',
                'phone'         => '082320099971',
                'email'         => 'zulfr@bprbangunarta.co.id',
                'role'          => 'Super Admin',
                'kantor_id'     => 9,
                'kode'          => 'ZFR',
                'kode_kolektor' => 895,
            ]);

            $u1 = User::factory()->create([
                'name'          => 'Apip',
                'username'      => 'apip',
                'phone'         => '085221561458',
                'email'         => 'apip@bprbangunarta.co.id',
                'role'          => 'Super Admin',
                'kantor_id'     => 9,
                'kode'          => 'APP',
                'kode_kolektor' => 894,
            ]);

            $u2 = User::factory()->create([
                'name'          => 'Yandi Rosyandi',
                'username'      => 'yandi',
                'phone'         => '081242758273',
                'email'         => 'yandi@bprbangunarta.co.id',
                'role'          => 'Super Admin',
                'kantor_id'     => 9,
                'kode'          => 'YRY',
                'kode_kolektor' => 921,
            ]);

            $guest = User::factory()->create([
                'name'     => 'Guest',
                'username' => 'guest',
                'phone'    => NULL,
                'email'    => 'guest@gmail.com',
                'role'     => 'Guest',
            ]);

            Role::create(['name' => 'Super Admin']);
            Role::create(['name' => 'Direktur']);
            Role::create(['name' => 'Kepala Bagian Kredit']);
            Role::create(['name' => 'Kepala Bagian Audit']);
            Role::create(['name' => 'Kepala Seksi Kredit']);
            Role::create(['name' => 'Kepala Seksi Remedial']);
            Role::create(['name' => 'Kepala Seksi Customer Care']);
            Role::create(['name' => 'AO Kredit']);
            Role::create(['name' => 'Staff Remedial']);
            Role::create(['name' => 'Customer Care']);
            Role::create(['name' => 'Staff Audit']);
            Role::create(['name' => 'Guest']);

            Permission::create(['name' => 'Petugas Create']);
            Permission::create(['name' => 'Petugas Read']);
            Permission::create(['name' => 'Petugas Update']);
            Permission::create(['name' => 'Petugas Delete']);
            Permission::create(['name' => 'Kredit Create']);
            Permission::create(['name' => 'Kredit Read']);
            Permission::create(['name' => 'Kredit Update']);
            Permission::create(['name' => 'Kredit Delete']);
            Permission::create(['name' => 'Writeoff Create']);
            Permission::create(['name' => 'Writeoff Read']);
            Permission::create(['name' => 'Writeoff Update']);
            Permission::create(['name' => 'Writeoff Delete']);
            Permission::create(['name' => 'Agunan Create']);
            Permission::create(['name' => 'Agunan Read']);
            Permission::create(['name' => 'Agunan Update']);
            Permission::create(['name' => 'Agunan Delete']);
            Permission::create(['name' => 'Telebilling Create']);
            Permission::create(['name' => 'Telebilling Read']);
            Permission::create(['name' => 'Telebilling Update']);
            Permission::create(['name' => 'Telebilling Delete']);
            Permission::create(['name' => 'Tugas Create']);
            Permission::create(['name' => 'Tugas Read']);
            Permission::create(['name' => 'Tugas Update']);
            Permission::create(['name' => 'Tugas Delete']);
            Permission::create(['name' => 'Prospek Create']);
            Permission::create(['name' => 'Prospek Read']);
            Permission::create(['name' => 'Prospek Update']);
            Permission::create(['name' => 'Prospek Delete']);
            Permission::create(['name' => 'Verifikasi Create']);
            Permission::create(['name' => 'Verifikasi Read']);
            Permission::create(['name' => 'Verifikasi Update']);
            Permission::create(['name' => 'Verifikasi Delete']);

            $sa->assignRole($sa->role);
            $u1->assignRole($u1->role);
            $u2->assignRole($u2->role);
            $guest->assignRole($guest->role);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
