<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Imports\UsersImport;
use App\Models\Kantor;
use App\Models\Kolektor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $keyword = request('search');
        if ($keyword) {
            $users = User::with('roles')->where('name', 'like', "%$keyword%")
                ->orWhere('username', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%")
                ->orWhereHas('roles', function ($query) use ($keyword) {
                    $query->where('name', 'like', "%$keyword%");
                })
                ->orWhereHas('kantor', function ($query) use ($keyword) {
                    $query->where('nama', 'like', "%$keyword%");
                })
                ->orderBy('name', 'asc')
                ->paginate(10);
        } else {
            $users = User::orderBy('name', 'asc')->paginate(10);
        }

        $users->each(function ($user) {
            $user->status = $user->is_active == 0 ? 'badge bg-label-danger' : 'badge bg-label-primary';
        });

        return view('admin.user.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $roles = Role::whereNotIn('name', ['super-admin'])->get();
        $kantor = Kantor::all();
        $kolektor = Kolektor::where('typeao', 'M')->get();

        return view('admin.user.create', [
            'roles'     => $roles,
            'kantor'    => $kantor,
            'kolektor'  => $kolektor,
        ]);
    }

    public function store(UserCreateRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        $user->assignRole($request->role);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        $roles = Role::whereNotIn('name', ['admin'])->get();
        $kantor = Kantor::all();
        $kolektor = Kolektor::where('typeao', 'M')->get();
        $status = [
            [
                'id'    => '0',
                'name'  => 'Inactive'
            ],
            [
                'id'    => '1',
                'name'  => 'Active',
            ],
        ];

        return view('admin.user.edit', [
            'user'      => $user,
            'roles'     => $roles,
            'status'    => $status,
            'kantor'    => $kantor,
            'kolektor'  => $kolektor,
        ]);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->all();
        $user->update($data);
        $user->syncRoles($request->role);

        return redirect()->back()->with('success', 'User berhasil diubah');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
