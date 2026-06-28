<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PhoneBlacklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PhoneBlacklistController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('s', '');
        $entries = PhoneBlacklist::when($search, fn ($q) => $q->where('phone', 'like', "%{$search}%")
            ->orWhere('reason', 'like', "%{$search}%"))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        // Attach order stats per phone
        $phones = $entries->pluck('phone');
        $stats = Order::whereIn('shipping_phone', $phones)
            ->selectRaw('shipping_phone, count(*) as total, sum(status="cancelled") as cancelled, sum(status="returned") as returned')
            ->groupBy('shipping_phone')
            ->get()
            ->keyBy('shipping_phone');

        return view('Admin.phone_blacklist.index', compact('entries', 'search', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'phone'  => 'required|string|max:30|unique:phone_blacklists,phone',
            'reason' => 'nullable|string|max:255',
        ]);

        PhoneBlacklist::create([
            'phone'      => $data['phone'],
            'reason'     => $data['reason'] ?? null,
            'blocked_by' => Auth::guard('admin')->id(),
        ]);

        return back()->with('success', 'Phone number blacklisted successfully.');
    }

    public function destroy(PhoneBlacklist $phoneBlacklist)
    {
        $phoneBlacklist->delete();
        return back()->with('success', 'Phone number removed from blacklist.');
    }

    // Quick-block from order page
    public function blockFromOrder(Request $request)
    {
        $phone = $request->input('phone');

        if (!$phone) {
            return back()->with('error', 'No phone number provided.');
        }

        PhoneBlacklist::firstOrCreate(
            ['phone' => $phone],
            ['reason' => 'Blocked from order', 'blocked_by' => Auth::guard('admin')->id()]
        );

        return back()->with('success', "Phone {$phone} has been blacklisted.");
    }
}
