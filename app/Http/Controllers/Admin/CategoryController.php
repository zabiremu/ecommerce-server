<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->orderBy('name')->get();
        return view('Admin.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'home_visible' => 'nullable|boolean',
            'home_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:320',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
            'icon' => $request->icon,
            'home_visible' => $request->boolean('home_visible'),
            'home_order' => $request->home_order ?? 0,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'parent_id' => $request->parent_id,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category = Category::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully.',
            'category' => $category->load('parent'),
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'icon' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'home_visible' => 'nullable|boolean',
            'home_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:320',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . $category->id,
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->name),
            'icon' => $request->icon,
            'home_visible' => $request->boolean('home_visible'),
            'home_order' => $request->home_order ?? 0,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'parent_id' => $request->parent_id,
        ];

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully.',
            'category' => $category->fresh()->load('parent'),
        ]);
    }

    public function destroy(Category $category)
    {
        if ($category->children()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete category with subcategories. Remove subcategories first.',
            ], 422);
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully.',
        ]);
    }

    public function toggleStatus(Category $category)
    {
        $category->update([
            'status' => !$category->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category status updated.',
        ]);
    }

    public function getParents()
    {
        $categories = Category::whereNull('parent_id')->orderBy('name')->get(['id', 'name']);
        return response()->json($categories);
    }
}
