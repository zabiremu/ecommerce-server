<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
            'permissions.*'  => ['string', Rule::in(Role::permissionKeys())],
        ]);
        $this->guardEscalation($data);

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
        $this->guardRoleAccess($role);
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
            'permissions.*'  => ['string', Rule::in(Role::permissionKeys())],
        ]);
        $this->guardRoleAccess($role);
        $this->guardEscalation($data);

        // Permissions the editor doesn't hold show as locked boxes (not submitted);
        // keep whatever the role already had there instead of silently dropping it.
        $me = Auth::guard('admin')->user();
        $kept = $me->isSuperAdmin() ? [] : array_filter($role->permissions ?? [], fn ($p) => !$me->hasPermission($p));
        $permissions = array_values(array_unique(array_merge($data['permissions'] ?? [], $kept)));

        $role->update([
            'name'           => $data['name'],
            'slug'           => Str::slug($data['name']),
            'description'    => $data['description'] ?? null,
            'is_super_admin' => $me->isSuperAdmin() ? (bool) ($data['is_super_admin'] ?? false) : (bool) $role->is_super_admin,
            'permissions'    => $permissions,
        ]);

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role "' . $role->name . '" updated successfully.');
    }

    public function destroy(Role $role)
    {
        $this->guardRoleAccess($role);

        if ($role->admins()->exists()) {
            return back()->with('error', 'Cannot delete role — ' . $role->admins()->count() . ' admin(s) are assigned to it.');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted.');
    }

    /**
     * Non-super admins can't touch Super Admin roles or their own role
     * (that would let them raise their own access).
     */
    private function guardRoleAccess(Role $role): void
    {
        $me = Auth::guard('admin')->user();
        if ($me->isSuperAdmin()) return;

        if ($role->is_super_admin) {
            abort(403, 'Only a Super Admin can change a Super Admin role.');
        }
        if ($me->role_id === $role->id) {
            abort(403, 'You cannot change your own role. Ask a Super Admin.');
        }
    }

    /** Non-super admins can only grant permissions they have themselves. */
    private function guardEscalation(array $data): void
    {
        $me = Auth::guard('admin')->user();
        if ($me->isSuperAdmin()) return;

        if (!empty($data['is_super_admin'])) {
            throw ValidationException::withMessages(['is_super_admin' => 'Only a Super Admin can create Super Admin roles.']);
        }
        if (!$me->canGrantPermissions($data['permissions'] ?? [])) {
            throw ValidationException::withMessages(['permissions' => 'You can only grant permissions that you have yourself.']);
        }
    }
}
