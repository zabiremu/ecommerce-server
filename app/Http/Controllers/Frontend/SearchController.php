<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        if ($q === '') {
            $products = Product::published()
                ->withCount('orderItems as sold_count')
                ->orderByDesc('sold_count')
                ->orderByDesc('id')
                ->limit(6)
                ->get();
        } else {
            $products = Product::published()
                ->where('name', 'like', '%' . $q . '%')
                ->orderByDesc('id')
                ->limit(8)
                ->get();
        }

        return response()->json([
            'success'  => true,
            'popular'  => $q === '',
            'products' => $products->map(function (Product $p) {
                $hasSale = $p->sale_price && $p->sale_price < $p->selling_price;
                return [
                    'id'    => $p->id,
                    'title' => $p->name,
                    'img'   => $p->thumbnail ? Storage::url($p->thumbnail) : '',
                    'price' => (float) ($hasSale ? $p->sale_price : $p->selling_price),
                    'url'   => route('product-details') . '?slug=' . $p->slug,
                ];
            }),
        ]);
    }
}
