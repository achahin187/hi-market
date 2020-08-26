<?php

namespace App\Http\Middleware;

use Closure;

class checklang
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
        app()->setLocale('en');

        if(isset($_GET['lang']) && $_GET['lang'] == 'ar')
        {
            app()->setLocale('ar');
        }
        return $next($request);
    }
}
