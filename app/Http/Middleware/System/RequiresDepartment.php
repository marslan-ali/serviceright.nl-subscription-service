<?php

namespace App\Http\Middleware\System;

use Closure;

class RequiresDepartment
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('X-Department') === false) {
            abort(400, 'Requires Department');
        }

        return $next($request);
    }
}
