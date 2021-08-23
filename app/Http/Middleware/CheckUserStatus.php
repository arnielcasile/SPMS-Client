<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;


class CheckUserStatus
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
        $status = \Auth::user()->deleted_at;
        if(Auth::check())
        {
            if($status!=null)
            {
                Auth::logout();
                return Redirect::to('login');
            }  
        }
      return $next($request);
    }
}
