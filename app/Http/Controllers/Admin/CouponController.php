<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $search = trim((string) $request->query('s', ''));

        $query = Coupon::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $today = Carbon::today();
        if ($filter === 'active') {
            $query->where('status', true)
                  ->where(function ($q) use ($today) {
                      $q->whereNull('expires_at')->orWhere('expires_at', '>=', $today);
                  })
                  ->where(function ($q) use ($today) {
                      $q->whereNull('starts_at')->orWhere('starts_at', '<=', $today);
                  });
        } elseif ($filter === 'expired') {
            $query->where('expires_at', '<', $today);
        } elseif ($filter === 'scheduled') {
            $query->where('starts_at', '>', $today);
        } elseif ($filter === 'inactive') {
            $query->where('status', false);
        }

        $coupons = $query->orderByDesc('id')->paginate(20)->withQueryString();

        $counts = [
            'all'       => Coupon::count(),
            'active'    => Coupon::active()
                ->where(function ($q) use ($today) { $q->whereNull('expires_at')->orWhere('expires_at', '>=', $today); })
                ->where(function ($q) use ($today) { $q->whereNull('starts_at')->orWhere('starts_at', '<=', $today); })
                ->count(),
            'scheduled' => Coupon::where('starts_at', '>', $today)->count(),
            'expired'   => Coupon::where('expires_at', '<', $today)->count(),
            'inactive'  => Coupon::where('status', false)->count(),
        ];

        return view('Admin.coupon.index', compact('coupons', 'counts', 'filter', 'search'));
    }

    public function create()
    {
        return view('Admin.coupon.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['code'] = strtoupper(trim($data['code']));

        Coupon::create($data);

        return redirect()->route('admin.coupons.index')
            ->with('success', "Coupon \"{$data['code']}\" created successfully.");
    }

    public function edit(Coupon $coupon)
    {
        return view('Admin.coupon.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $data = $this->validateData($request, $coupon->id);
        $data['code'] = strtoupper(trim($data['code']));

        $coupon->update($data);

        return redirect()->route('admin.coupons.index')
            ->with('success', "Coupon \"{$coupon->code}\" updated.");
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted.');
    }

    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update(['status' => !$coupon->status]);
        return back()->with('success', 'Coupon status updated.');
    }

    public function generateCode()
    {
        do {
            $code = 'NF' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        } while (Coupon::where('code', $code)->exists());

        return response()->json(['code' => $code]);
    }

    protected function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'code'                     => ['required', 'string', 'max:50',
                                          'unique:coupons,code' . ($ignoreId ? ",{$ignoreId}" : '')],
            'description'              => 'nullable|string|max:255',
            'type'                     => 'required|in:percentage,fixed',
            'amount'                   => 'required|numeric|min:0',
            'minimum_spend'            => 'nullable|numeric|min:0',
            'maximum_discount'         => 'nullable|numeric|min:0',
            'usage_limit'              => 'nullable|integer|min:1',
            'usage_limit_per_customer' => 'nullable|integer|min:1',
            'free_shipping'            => 'nullable|boolean',
            'individual_use_only'      => 'nullable|boolean',
            'exclude_sale_items'       => 'nullable|boolean',
            'starts_at'                => 'nullable|date',
            'expires_at'               => 'nullable|date|after_or_equal:starts_at',
            'status'                   => 'nullable|boolean',
        ]);
    }
}
