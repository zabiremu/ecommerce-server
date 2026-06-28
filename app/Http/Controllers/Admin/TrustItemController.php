<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrustItem;
use Illuminate\Http\Request;

class TrustItemController extends Controller
{
    public function index()
    {
        $items = TrustItem::orderBy('sort_order')->orderByDesc('id')->get();
        return view('Admin.trust_item.index', compact('items'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $item = TrustItem::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Trust item created successfully.',
            'item' => $item,
        ]);
    }

    public function update(Request $request, TrustItem $trustItem)
    {
        $data = $this->validateData($request);

        $trustItem->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Trust item updated successfully.',
            'item' => $trustItem->fresh(),
        ]);
    }

    public function destroy(TrustItem $trustItem)
    {
        $trustItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Trust item deleted successfully.',
        ]);
    }

    public function toggleStatus(TrustItem $trustItem)
    {
        $trustItem->update(['status' => !$trustItem->status]);

        return response()->json([
            'success' => true,
            'message' => 'Trust item status updated.',
        ]);
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'icon'        => 'nullable|string|max:100',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'sort_order'  => 'nullable|integer|min:0',
        ]);
    }
}
