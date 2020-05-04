<?php

namespace App\Http\Middleware\System;

use Closure;
use Illuminate\Support\Facades\Log;

class SupportMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->user()->hasPermission('subscription-service-allow-support-agents') === false) {
            Log::warning('User is not an support employee but tries to access the resource', [
                'user' => $request->user()->getKey(),
                'ip' => $request->ip(),
                'blocked_access' => true
            ]);
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}