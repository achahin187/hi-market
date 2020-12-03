<?php
use App\Models\Client;

if(!function_exists("getUser"))
{
    function getUser()
    {
      return  auth('client-api')->check() ? auth('client-api')->user() : 'done';
    }
}
// Client::where('unique_id',request()->header('udid')