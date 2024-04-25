<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $keyword = request('search');
        if ($keyword) {
            $roles = Role::where('name', 'LIKE', "%$keyword%")
                ->orWhere('guard_name', 'LIKE', "%$keyword%")
                ->orderBy('name', 'ASC')
                ->paginate(10);
        } else {
            $roles = Role::orderBy('name', 'ASC')->paginate(10);
        }

        return view('admin.role.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ], [
            'name.required' => 'Role name is required',
            'name.unique'   => 'Role name is already taken',
        ]);

        Role::create([
            'name'       => $request->name,
            'guard_name' => $request->guard_name ?? 'web'
        ]);

        return redirect()->back()->with('success', 'Role berhasil ditambahkan');
    }

    public function edit(Role $role)
    {
        $keyword = request('search');
        if ($keyword) {
            $roles = Role::where('name', 'LIKE', "%$keyword%")
                ->orWhere('guard_name', 'LIKE', "%$keyword%")
                ->orderBy('name', 'ASC')
                ->paginate(10);
        } else {
            $roles = Role::orderBy('name', 'ASC')->paginate(10);
        }

        if (!$role) {
            return redirect()->back()->with('error', 'Role tidak ditemukan');
        }
        return view('admin.role.edit', compact('role', 'roles'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ], [
            'name.required' => 'Role name is required',
            'name.unique'   => 'Role name is already taken',
        ]);

        $role->update([
            'name'       => $request->name,
            'guard_name' => $request->guard_name ?? 'web'
        ]);

        $role->users()->update(['role' => $request->name]);
        $role->users->each->assignRole($request->name);

        return redirect()->back()->with('success', 'Role berhasil diubah');
    }

    public function destroy(Role $role)
    {
        if (!$role) {
            return redirect()->back()->with('error', 'Role tidak ditemukan');
        }

        $role->delete();
        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus');
    }
}
