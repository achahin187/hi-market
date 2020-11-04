<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Clientdevice;
use App\Models\Coverage_area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\generaltrait;

class LocationController extends Controller
{
    //
    use generaltrait;

    function index(Request $request)
    {

        $lang = $request->header('lang');
        $udid = $request->header('udid');
        $token = $request->header('token');

        if (!$lang || $lang == '') {
            return $this->returnError(402, 'language is missing');
        }


        $long = $request->long;

        $lat = $request->lat;

        $data = Coverage_area::where('lat', $lat)->where('long', $long)->where('status','active')->first();


        if ($data)
        {

            if($token) {

                $client = Client::where('remember_token', $token)->first();

                if ($client) {
                    if ($lang == 'ar') {
                        return $this->returnSuccessMessage('العنوان صحيح ', 200);
                    } else {
                        return $this->returnSuccessMessage('location is valid', 200);
                    }
                } else {
                    if ($lang == 'ar') {
                        return $this->returnError(305, 'لم نجد هذا العميل');
                    }
                    return $this->returnError(305, 'there is no client found');
                }
            }

            if ($lang == 'ar') {
                return $this->returnSuccessMessage('العنوان صحيح ', 200);
            } else {
                return $this->returnSuccessMessage('location is valid', 200);
            }
        }
        else
        {
            if ($lang == 'ar') {
                return $this->returnError(402, 'لا نغطي هذه المساحة');
            } else {
                return $this->returnError(402, 'this area is not included');
            }
        }


    }
}
