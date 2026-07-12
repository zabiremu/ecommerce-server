<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string|max:1000',
            'photos'     => 'nullable|array|max:4',
            'photos.*'   => 'image|max:2048',
        ]);

        $photoPaths = [];
        foreach ($request->file('photos', []) as $photo) {
            $photoPaths[] = $photo->store('reviews', 'public');
        }

        $customer = Auth::guard('web')->user();

        $review = ProductReview::create([
            'product_id' => $data['product_id'],
            'name'       => $customer->name,
            'email'      => $customer->email,
            'rating'     => $data['rating'],
            'comment'    => $data['comment'],
            'photos'     => $photoPaths ?: null,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
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

        return back()->with('success', 'Thanks for your review!');
    }
}
