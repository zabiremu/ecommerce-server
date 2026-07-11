<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstagramPostController extends Controller
{
    public function index()
    {
        $instagramPosts = InstagramPost::orderBy('sort_order')->orderByDesc('id')->get();
        return view('Admin.instagram-post.index', compact('instagramPosts'));
    }

    public function create()
    {
        return view('Admin.instagram-post.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['image'] = $request->file('image')->store('instagram-posts', 'public');
        $data['status'] = $request->boolean('status');

        InstagramPost::create($data);

        return redirect()->route('admin.instagram-posts.index')
            ->with('success', 'Instagram post created successfully.');
    }

    public function edit(InstagramPost $instagramPost)
    {
        return view('Admin.instagram-post.edit', compact('instagramPost'));
    }

    public function update(Request $request, InstagramPost $instagramPost)
    {
        $data = $this->validateData($request, true);
        $data['status'] = $request->boolean('status');

        if ($request->hasFile('image')) {
            if ($instagramPost->image) {
                Storage::disk('public')->delete($instagramPost->image);
            }
            $data['image'] = $request->file('image')->store('instagram-posts', 'public');
        }

        $instagramPost->update($data);

        return redirect()->route('admin.instagram-posts.index')
            ->with('success', 'Instagram post updated successfully.');
    }

    public function destroy(InstagramPost $instagramPost)
    {
        if ($instagramPost->image) {
            Storage::disk('public')->delete($instagramPost->image);
        }
        $instagramPost->delete();

        return redirect()->route('admin.instagram-posts.index')
            ->with('success', 'Instagram post deleted.');
    }

    public function toggleStatus(InstagramPost $instagramPost)
    {
        $instagramPost->update(['status' => !$instagramPost->status]);
        return back()->with('success', 'Instagram post status updated.');
    }

    protected function validateData(Request $request, bool $imageOptional = false): array
    {
        return $request->validate([
            'link'            => 'nullable|url|max:255',
            'likes_count'     => 'nullable|integer|min:0',
            'comments_count'  => 'nullable|integer|min:0',
            'sort_order'      => 'nullable|integer|min:0',
            'image'           => ($imageOptional ? 'nullable' : 'required') . '|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);
    }
}
