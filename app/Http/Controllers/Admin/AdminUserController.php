<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = Admin::with('role')->latest()->get();
        return view('Admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = $this->assignableRoles();
        return view('Admin.admins.form', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:admins,email',
            'password'              => 'required|string|min:8|confirmed',
            'role_id'               => 'nullable|exists:roles,id',
        ]);
        $this->guardRoleAssignment($data['role_id'] ?? null);

        Admin::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id'  => $data['role_id'] ?: null,
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin user "' . $data['name'] . '" created successfully.');
    }

    public function edit(Admin $admin)
    {
        $this->guardAdminAccess($admin);
        $roles = $this->assignableRoles();
        return view('Admin.admins.form', compact('admin', 'roles'));
    }

    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'password'              => 'nullable|string|min:8|confirmed',
            'role_id'               => 'nullable|exists:roles,id',
        ]);
        $this->guardAdminAccess($admin);

        $me = Auth::guard('admin')->user();
        if ($admin->id === $me->id && !$me->isSuperAdmin()) {
            $data['role_id'] = $admin->role_id;   // can't change your own role
        } elseif ((int) ($data['role_id'] ?? 0) !== (int) $admin->role_id) {
            $this->guardRoleAssignment($data['role_id'] ?? null);
        }

        $update = [
            'name'    => $data['name'],
            'email'   => $data['email'],
            'role_id' => $data['role_id'] ?: null,
        ];

        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        $admin->update($update);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin user "' . $admin->name . '" updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === Auth::guard('admin')->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($admin->isSuperAdmin()) {
            return back()->with('error', 'Super Admins cannot be deleted.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin user deleted.');
    }

    /** Roles the current admin may hand out (everything for a Super Admin). */
    private function assignableRoles()
    {
        $me = Auth::guard('admin')->user();
        return Role::orderBy('name')->get()->filter(fn (Role $r) => $me->canGrantRole($r))->values();
    }

    /** Non-super admins can't assign "no role" (= Super Admin) or a role stronger than their own. */
    private function guardRoleAssignment($roleId): void
    {
        $me = Auth::guard('admin')->user();
        if ($me->isSuperAdmin()) return;

        $role = $roleId ? Role::find($roleId) : null;
        if (!$me->canGrantRole($role)) {
            throw ValidationException::withMessages([
                'role_id' => $role
                    ? 'You can only assign roles whose permissions you have yourself.'
                    : 'Only a Super Admin can create another Super Admin.',
            ]);
        }
    }

    /** Non-super admins can't edit Super Admin accounts. */
    private function guardAdminAccess(Admin $admin): void
    {
        $me = Auth::guard('admin')->user();
        if (!$me->isSuperAdmin() && $admin->isSuperAdmin()) {
            abort(403, 'Only a Super Admin can edit a Super Admin account.');
        }
    }
}
