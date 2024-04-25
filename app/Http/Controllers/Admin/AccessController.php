<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class AccessController extends Controller
{
    public function user(User $user)
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();

        $petugas = $permissions->filter(function ($permission) {
            return strpos($permission->name, 'Petugas ') === 0;
        });

        $kredit = $permissions->filter(function ($permission) {
            return strpos($permission->name, 'Kredit ') === 0;
        });

        $writeoff = $permissions->filter(function ($permission) {
            return strpos($permission->name, 'Writeoff ') === 0;
        });

        $agunan = $permissions->filter(function ($permission) {
            return strpos($permission->name, 'Agunan ') === 0;
        });

        $tebil = $permissions->filter(function ($permission) {
            return strpos($permission->name, 'Telebilling ') === 0;
        });

        $tugas = $permissions->filter(function ($permission) {
            return strpos($permission->name, 'Tugas ') === 0;
        });

        $prospek = $permissions->filter(function ($permission) {
            return strpos($permission->name, 'Prospek ') === 0;
        });

        $Verifikasi = $permissions->filter(function ($permission) {
            return strpos($permission->name, 'Verifikasi ') === 0;
        });

        return view('admin.access.user', [
            'user'       => $user,
            'petugas'    => $petugas,
            'kredit'     => $kredit,
            'writeoff'   => $writeoff,
            'agunan'     => $agunan,
            'tebil'      => $tebil,
            'tugas'      => $tugas,
            'prospek'    => $prospek,
            'verifikasi' => $Verifikasi,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'permissions' => 'required|array',
        ], [
            'permissions.required' => 'Silakan pilih setidaknya satu akses',
            'permissions.array'    => 'Hak akses harus berupa array',

        ]);

        $user->givePermissionTo($request->permissions);
        $user->syncPermissions($request->permissions);
        return redirect()->back()->with('success', 'Hak akses berhasil diubah');
    }
}
