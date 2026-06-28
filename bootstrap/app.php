<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.permission' => \App\Http\Middleware\CheckAdminPermission::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\TrackVisitor::class,
        ]);
        $middleware->redirectGuestsTo(fn () => route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // "Page Expired" (419) most often hits mobile users whose browser served a
        // cached login form with a stale CSRF token. Instead of the blank 419 page,
        // send them back to the form with a friendly message so they can retry.
        $exceptions->render(function (TokenMismatchException $e, $request) {
            return redirect()
                ->back()
                ->withInput($request->except('password'))
                ->with('expired', 'সেশনের মেয়াদ শেষ হয়ে গেছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
        });
    })->create();
