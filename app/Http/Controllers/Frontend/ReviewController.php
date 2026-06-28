<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'name'       => 'required|string|max:100',
            'email'      => 'nullable|email|max:150',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string|max:1000',
        ]);

        $review = ProductReview::create($data);

        return response()->json([
            'success' => true,
            'review'  => [
                'name'       => $review->name,
                'rating'     => $review->rating,
                'comment'    => $review->comment,
                'created_at' => $review->created_at->format('d M Y'),
            ],
        ]);
    }
}
