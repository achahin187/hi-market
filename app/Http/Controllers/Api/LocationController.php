<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Clientdevice;
use App\Models\Coverage_area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\GeneralTrait;

class LocationController extends Controller
{
    //
    use GeneralTrait;

    function index(Request $request)
    {


        $long = $request->long;

        $lat = $request->lat;

        $data = Coverage_area::where('lat', $lat)->where('long', $long)->where('status', 'active')->first();


        if ($data) {


            $client = getUser();

            if ($client) {

                return $this->returnSuccessMessage('location is valid', 200);

            } else {

                return $this->returnError(404, 'there is no client found');
            }
        } else {
            return $this->returnSuccessMessage('location is valid', 200);
        }
    }


}
