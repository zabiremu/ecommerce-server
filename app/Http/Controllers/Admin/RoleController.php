<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount('admins')->latest()->get();
        return view('Admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Role::allPermissions();
        return view('Admin.roles.form', compact('permissions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:100|unique:roles,name',
            'description'    => 'nullable|string|max:500',
            'is_super_admin' => 'boolean',
            'permissions'    => 'nullable|array',
            'permissions.*'  => 'string',
        ]);

        Role::create([
            'name'           => $data['name'],
            'slug'           => Str::slug($data['name']),
            'description'    => $data['description'] ?? null,
            'is_super_admin' => (bool) ($data['is_super_admin'] ?? false),
            'permissions'    => $data['permissions'] ?? [],
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role "' . $data['name'] . '" created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Role::allPermissions();
        return view('Admin.roles.form', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:100|unique:roles,name,' . $role->id,
            'description'    => 'nullable|string|max:500',
            'is_super_admin' => 'boolean',
            'permissions'    => 'nullable|array',
            'permissions.*'  => 'string',
        ]);

        $role->update([
            'name'           => $data['name'],
            'slug'           => Str::slug($data['name']),
            'description'    => $data['description'] ?? null,
            'is_super_admin' => (bool) ($data['is_super_admin'] ?? false),
            'permissions'    => $data['permissions'] ?? [],
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role "' . $role->name . '" updated successfully.');
    }

    public function destroy(Role $role)
    {
        if ($role->admins()->exists()) {
            return back()->with('error', 'Cannot delete role — ' . $role->admins()->count() . ' admin(s) are assigned to it.');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted.');
    }
}
