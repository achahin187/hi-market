<?php


use App\Models\Client;
use App\Models\Udid;

if (!function_exists("getUser")) {
    function getUser()
    {

            return auth('client-api')->check() ? auth('client-api')->user() : Client::where("unique_id",request()->header("udid"))->first();


    }
}
