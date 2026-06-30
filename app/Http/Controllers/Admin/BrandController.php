<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name')->get();
        return view('Admin.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $brand = Brand::create([
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
            'icon' => $request->hasFile('icon') ? $request->file('icon')->store('brands', 'public') : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Brand created successfully.',
            'brand' => $brand,
        ]);
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brands,slug,' . $brand->id,
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
        ];

        if ($request->hasFile('icon')) {
            if ($brand->icon) {
                Storage::disk('public')->delete($brand->icon);
            }
            $data['icon'] = $request->file('icon')->store('brands', 'public');
        }

        $brand->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Brand updated successfully.',
            'brand' => $brand->fresh(),
        ]);
    }

    public function destroy(Brand $brand)
    {
        if ($brand->icon) {
            Storage::disk('public')->delete($brand->icon);
        }
        $brand->delete();

        return response()->json([
            'success' => true,
            'message' => 'Brand deleted successfully.',
        ]);
    }

    public function toggleStatus(Brand $brand)
    {
        $brand->update([
            'status' => !$brand->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Brand status updated.',
        ]);
    }
}
