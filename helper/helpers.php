<?php


use App\Models\Udid;

if (!function_exists("getUser")) {
    function getUser()
    {

            return auth('client-api')->check() ? auth('client-api')->user() : Udid::where("body",request()->header("udid"))->first();


    }
}
