<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        // Honeypot: real users never fill this hidden field, bots that blindly fill every input do.
        // Fail silently with a fake success so bots don't learn they were caught.
        if (filled($request->input('website'))) {
            return response()->json([
                'success' => true,
                'message' => 'Thanks for subscribing! Check your inbox for your 10% off code.',
            ]);
        }

        $data = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $existing = Subscriber::where('email', $data['email'])->first();

        if ($existing) {
            return response()->json([
                'success' => true,
                'message' => "You're already subscribed — thanks for sticking around!",
            ]);
        }

        Subscriber::create([
            'email'  => $data['email'],
            'source' => 'homepage',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thanks for subscribing! Check your inbox for your 10% off code.',
        ]);
    }
}
