<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DealsBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
            'starts_at'       => 'nullable|date',
            'ends_at'         => 'nullable|date|after:starts_at',
        ], [
            'ends_at.after' => 'The sale end time must be after the start time.',
        ]);
        $data['status'] = $request->boolean('status');

        // The form uses shop-local time (Bangladesh); store UTC.
        foreach (['starts_at', 'ends_at'] as $field) {
            $data[$field] = !empty($data[$field])
                ? Carbon::parse($data[$field], DealsBanner::LOCAL_TZ)->utc()
                : null;
        }

        DealsBanner::current()->update($data);

        return redirect()->route('admin.deals-banner.edit')
            ->with('success', 'Deals banner updated successfully.');
    }
}
