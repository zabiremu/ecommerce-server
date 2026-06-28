<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('s', ''));
        $filter = $request->query('filter', 'all');

        $query = Customer::query()->withCount(['orders']);

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($filter === 'active') $query->where('status', true);
        if ($filter === 'inactive') $query->where('status', false);
        if ($filter === 'with-orders') $query->where('total_orders', '>', 0);
        if ($filter === 'no-orders') $query->where('total_orders', 0);

        $customers = $query->orderByDesc('total_spent')->paginate(20)->withQueryString();

        $counts = [
            'all'          => Customer::count(),
            'active'       => Customer::where('status', true)->count(),
            'inactive'     => Customer::where('status', false)->count(),
            'with-orders'  => Customer::where('total_orders', '>', 0)->count(),
            'no-orders'    => Customer::where('total_orders', 0)->count(),
        ];

        return view('Admin.customer.index', compact('customers', 'counts', 'search', 'filter'));
    }

    public function show(Customer $customer)
    {
        $customer->recalculateStats();
        $customer->load(['orders' => function ($q) {
            $q->reorder()->latest('id')->limit(50);
        }, 'orders.items']);
        return view('Admin.customer.show', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:30|unique:customers,phone,' . $customer->id,
            'email'   => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'city'    => 'nullable|string|max:100',
            'area'    => 'nullable|string|max:100',
            'notes'   => 'nullable|string|max:1000',
        ]);

        $customer->update($request->only(['name', 'phone', 'email', 'address', 'city', 'area', 'notes']));
        return back()->with('success', 'Customer details updated.');
    }

    public function toggleStatus(Customer $customer)
    {
        $customer->update(['status' => !$customer->status]);
        return back()->with('success', 'Customer status updated.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->orders()->exists()) {
            return back()->with('error', 'Cannot delete a customer with orders. Disable instead.');
        }
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted.');
    }
}
