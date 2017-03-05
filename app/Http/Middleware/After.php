<?php

namespace App\Http\Middleware;

use Closure;

class After
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $response;
    }
}
