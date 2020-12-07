<?php

namespace App\Http\Middleware;

use Closure;

class Checklang
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


        if(request()->header("lang"))
        {
            app()->setLocale(request()->header("lang"));
        }else{
            app()->setLocale('ar');
        }
        return $next($request);
    }
}
