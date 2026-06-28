<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id')->get();
        return view('Admin.pages.index', compact('pages'));
    }

    public function edit(Page $page)
    {
        return view('Admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title'              => 'required|string|max:255',
            'subtitle'           => 'nullable|string|max:500',
            'icon'               => 'nullable|string|max:100',
            'content'            => 'nullable|string',
            'last_updated_label' => 'nullable|string|max:100',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string|max:500',
        ]);

        $page->update($request->only([
            'title', 'subtitle', 'icon', 'content',
            'last_updated_label', 'meta_title', 'meta_description',
        ]));

        return redirect()->route('admin.pages.edit', $page)
            ->with('success', '«' . $page->title . '» page updated successfully.');
    }
}
