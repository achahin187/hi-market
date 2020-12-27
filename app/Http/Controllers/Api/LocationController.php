<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Clientdevice;
use App\Models\Polygon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Polygons\PointLocation;
use App\Http\Traits\GeneralTrait;

class LocationController extends Controller
{
    //
    use GeneralTrait;

    function index(Request $request)
    {


        $long = $request->long;

        $lat = $request->lat;

          $pointLocation = new PointLocation();

          $polygon = Polygon::all()->toArray();
          $points = array("$request->long $request->lat");

          $data = $pointLocation->pointInPolygon($point, $polygon) ;
            

            dd($data);
        if ($data == true) {
                return $this->returnSuccessMessage('location is valid', 200);

        } else {
            return $this->returnSuccessMessage('location is valid', 200);
        }
    }


}
