<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        if (!$lang || $lang == '') {
            return $this->returnError(402, 'language is missing');
        }

        $device = Client_Devices::where('udid', $udid)->first();

        $long = $request->long;

        $lat = $request->lat;


        if ($device == null) {

            $client_device = Client_Devices::create([

                'udid' => $udid
            ]);
        }

        $data = DB::table('areas')
            ->select('area.*')
            ->where('lat', $lat)->where('long', $long)
            ->get();

        if ($data)
        {
            if ($lang == 'ar') {
                return $this->returnSuccessMessage(200, 'العنوان صحيح');
            } else {
                return $this->returnSuccessMessage(200, 'location is valid');
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
