<?php

namespace App\Http\Middleware;

use App\Http\Traits\generaltrait;
use App\Models\Client;
use Closure;

class CheckMobileSerial
{
    use generaltrait;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        

        if (!request()->header("Authorization") && !$request->header("udid")) {

            return $this->returnError(401, "please pass Authorization header or udid");
        }

        return $next($request);
    }
}
