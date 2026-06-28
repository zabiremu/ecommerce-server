<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = Admin::with('role')->latest()->get();
        return view('Admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();
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
        $roles = Role::orderBy('name')->get();
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
}
