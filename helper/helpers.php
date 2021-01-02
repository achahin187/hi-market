<?php


use App\Models\Client;
use App\Models\Udid;

if (!function_exists("getUser")) {
    function getUser()
    {

            return auth('client-api')->check() ? auth('client-api')->user() : Udid::where("body",request()->header("udid"))->first();


    }
}

if (!function_exists("formatNumber")) {
    function formatNumber($num, $digits = null)
    {
        $pow = pow(10, $digits === null ? 6 : $digits);
        return round($num * $pow) / $pow;
    }
}
if (!function_exists("trim")) {
    function trim($str)
    {
        return trim($str);
    }
}
if (!function_exists("splitWords")) {
    function splitWords($str)
    {
        $text = trim($str);
        return explode(" ", $text);
    }
}
if (!function_exists("wrapNum")) {
    function wrapNum($x, array $range, $includeMax = false)
    {
        $max = $range[1];
        $min = $range[0];
        $d = $max - $min;
        return $x === $max && $includeMax ? $x : (($x - $min) % $d + $d) % $d + $min;
    }
}

if (!function_exists("branchTotal")) {
    function branchTotal($branch_id)
    {
        return \App\Models\Order::Where('branch_id', $branch_id)->sum('total_before');
    }
}

if (!function_exists("CompanyTotal")) {
    function  CompanyTotal($company_id)
    {
        return \App\Models\Order::Where('company_id', $company_id)->sum('shipping_before');
    }
}

