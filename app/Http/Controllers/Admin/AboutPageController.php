<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;

class AboutPageController extends Controller
{
    public function edit()
    {
        $page = Page::where('slug', 'about')->firstOrFail();

        return view('Admin.pages.edit', compact('page'));
    }
}
