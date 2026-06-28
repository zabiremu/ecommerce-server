<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DealsBanner;
use Illuminate\Http\Request;

class DealsBannerController extends Controller
{
    public function edit()
    {
        $banner = DealsBanner::current();
        return view('Admin.deals_banner.edit', compact('banner'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'emoji'           => 'nullable|string|max:10',
            'title'           => 'required|string|max:255',
            'title_highlight' => 'nullable|string|max:255',
            'description'     => 'nullable|string|max:1000',
            'button_text'     => 'nullable|string|max:100',
            'button_link'     => 'nullable|string|max:500',
        ]);
        $data['status'] = $request->boolean('status');

        DealsBanner::current()->update($data);

        return redirect()->route('admin.deals-banner.edit')
            ->with('success', 'Deals banner updated successfully.');
    }
}
