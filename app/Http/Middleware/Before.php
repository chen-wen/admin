<?php

namespace App\Http\Middleware;

use Closure, DB, Auth;

class Before
{
    public function handle($request, Closure $next)
    {
        DB::enableQueryLog();

        if(Auth::check()){
            $user = Auth::user();
            view()->share('NAV', $user->getSelfNav());
            view()->share('MENU', $user->getCurrentMenu());
            view()->share('CURRENT_NAV', $user->getCurrentNav());
            view()->share('CURRENT_ROUTE', $user->currentMenuName());
        }
        return $next($request);
    }
}
