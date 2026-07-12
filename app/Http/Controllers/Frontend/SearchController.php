<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SearchLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $popularTerms = [];

        if ($q === '') {
            $popularTerms = SearchLog::select('term')
                ->selectRaw('COUNT(*) as cnt')
                ->groupBy('term')
                ->orderByDesc('cnt')
                ->limit(6)
                ->pluck('term');

            $products = Product::published()
                ->withCount('orderItems as sold_count')
                ->orderByDesc('sold_count')
                ->orderByDesc('id')
                ->limit(6)
                ->get();
        } else {
            $products = Product::published()
                ->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('sku', 'like', "%{$q}%")
                        ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$q}%"))
                        ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$q}%"));
                })
                ->orderByDesc('id')
                ->limit(8)
                ->get();

            SearchLog::create(['term' => Str::lower($q)]);
        }

        return response()->json([
            'success'      => true,
            'popular'      => $q === '',
            'popularTerms' => $popularTerms,
            'products'     => $products->map(function (Product $p) {
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
