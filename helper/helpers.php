<?php
if(!function_exists("getUser"))
{
    function getUser()
    {
      return  auth("client-api")->check() ? auth("client-api")->user() : \App\Models\Client::where("unique_id",request()->header("udid"))->firstOrFail();
    }
}
