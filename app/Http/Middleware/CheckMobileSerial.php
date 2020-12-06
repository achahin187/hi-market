<?php

namespace App\Http\Middleware;

use App\Http\Traits\GeneralTrait;
use App\Models\Client;
use Closure;

class CheckMobileSerial
{
    use GeneralTrait;

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
