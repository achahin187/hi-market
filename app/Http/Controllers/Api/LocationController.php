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

          $getpolygon = Polygon::all();
          $polygon=[];
          
          foreach ($getpolygon as $key => $value) {
             $polygon[] = $value->lat;
             $polygon[]     = $value->lon;
          }
          //return str_replace(',', ' ', $polygon)  ;
          //$polygons =  implode(' ', $polygon);
       
          $point = implode(' ', array($long, $lat));

          $data = $pointLocation->pointInPolygon($point, $polygon) ;
            

            
        if ($data == true) {
                return $this->returnSuccessMessage('location is valid', 200);

        } else {
            return $this->returnSuccessMessage('location is valid', 200);
        }
    }


}
