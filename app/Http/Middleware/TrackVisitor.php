<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only track frontend page requests (not admin, not AJAX/API, not assets)
        if (
            !$request->is('admin*') &&
            !$request->is('api*') &&
            !$request->ajax() &&
            $request->method() === 'GET'
        ) {
            $sessionId = $request->session()->getId();

            DB::table('visitor_sessions')->upsert(
                [
                    'session_id'   => $sessionId,
                    'ip_address'   => $request->ip(),
                    'last_seen_at' => now(),
                ],
                ['session_id'],
                ['ip_address', 'last_seen_at']
            );

            // Record one entry per session per day for historical analytics
            DB::table('visitor_logs')->insertOrIgnore([
                'session_id'   => $sessionId,
                'ip_address'   => $request->ip(),
                'visited_date' => today()->toDateString(),
            ]);

            // Probabilistic cleanup: ~2% of requests prune stale sessions
            if (random_int(1, 50) === 1) {
                DB::table('visitor_sessions')
                    ->where('last_seen_at', '<', now()->subMinutes(15))
                    ->delete();
            }
        }

        return $next($request);
    }
}
