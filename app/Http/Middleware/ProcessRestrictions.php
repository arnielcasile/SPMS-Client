<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class ProcessRestrictions
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
        $process = \Auth::user()->process;
        $process_array=explode(",",$process);
        $route_collection=
        [
            "dashboard",
            "master-data",
            "leadtime-data",
            "monitoring-report",
            "parts-status",
            "delivery-data",
            "forecast",
            "picker",
            "reprint",//reprint
            "irreg-create",
            "irreg-update",
            "lead-time-report",
            "overall-graph-report",
            "pallet-report",
            "checking",
            "palletizing",
            "#",//parts for dr
            "update-delivery",
            "remarks",
        ];
        for($x=0;$x<count($route_collection);$x++)
        {
            if($request->path() == $route_collection[$x])
            {
                if($process_array[$x]=="0")
                {
                    return redirect('/dashboard');
                }
                else
                {
                    return $next($request);
                }
            }
        }

    }
}
