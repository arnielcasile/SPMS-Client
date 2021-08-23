<?php

namespace App\Http\Middleware;

use Closure;

class ReceiverRestrictions
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
        $receiver = \Auth::user()->receiver;

        if ($receiver === 0)
        {
            return redirect('dashboard');
        }
        return $next($request);
    }
}
