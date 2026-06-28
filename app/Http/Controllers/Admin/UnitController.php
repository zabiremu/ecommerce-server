<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::orderBy('name')->get();
        return view('Admin.unit.index', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:units,slug',
        ]);

        $unit = Unit::create([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Unit created successfully.',
            'unit' => $unit,
        ]);
    }

    public function update(Request $request, Unit $unit)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:units,slug,' . $unit->id,
        ]);

        $unit->update([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Unit updated successfully.',
            'unit' => $unit->fresh(),
        ]);
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Unit deleted successfully.',
        ]);
    }

    public function toggleStatus(Unit $unit)
    {
        $unit->update([
            'status' => !$unit->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Unit status updated.',
        ]);
    }
}
