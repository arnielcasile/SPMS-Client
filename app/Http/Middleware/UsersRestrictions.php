<?php

namespace App\Http\Middleware;

use Closure;

class UsersRestrictions
{
    public function handle($request, Closure $next)
    {
        $user_type = \Auth::user()->user_type_id;

        if ($user_type === 3)
        {
            return redirect('dashboard');
        }
        return $next($request);
    }
}
