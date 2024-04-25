<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $keyword = request('search');
        if ($keyword) {
            $permissions = Permission::where('name', 'LIKE', "%$keyword%")
                ->orWhere('guard_name', 'LIKE', "%$keyword%")
                ->orderBy('name', 'ASC')
                ->paginate(10);
        } else {
            $permissions = Permission::orderBy('name', 'ASC')->paginate(10);
        }

        return view('admin.permission.index', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ], [
            'name.required' => 'Permission name is required',
            'name.unique'   => 'Permission name is already taken',
        ]);

        Permission::create([
            'name'       => $request->name,
            'guard_name' => $request->guard_name ?? 'web'
        ]);

        return redirect()->back()->with('success', 'Permission berhasil ditambahkan');
    }

    public function edit(Permission $permission)
    {
        $keyword = request('search');
        if ($keyword) {
            $permissions = Permission::where('name', 'LIKE', "%$keyword%")
                ->orWhere('guard_name', 'LIKE', "%$keyword%")
                ->orderBy('name', 'ASC')
                ->paginate(10);
        } else {
            $permissions = Permission::orderBy('name', 'ASC')->paginate(10);
        }

        if (!$permission) {
            return redirect()->back()->with('error', 'Permission tidak ditemukan');
        }
        return view('admin.permission.edit', compact('permission', 'permissions'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ], [
            'name.required' => 'Permission name is required',
            'name.unique'   => 'Permission name is already taken',
        ]);

        $permission->update([
            'name'       => $request->name,
            'guard_name' => $request->guard_name ?? 'web'
        ]);

        return redirect()->back()->with('success', 'Permission berhasil diubah');
    }

    public function destroy(Permission $permission)
    {
        if (!$permission) {
            return redirect()->back()->with('error', 'Permission tidak ditemukan');
        }

        $permission->delete();
        return redirect()->route('permission.index')->with('success', 'Permission berhasil dihapus');
    }
}
