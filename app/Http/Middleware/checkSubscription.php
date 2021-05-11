<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class checkSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if ($request->user() && ! $request->user()->subscribed('PREMIUM') || $user->subscription('PREMIUM')->ended()) {
            $user->update(['is_subscribed' => false]);
        }
        return $next($request);
    }
}
