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
      
          $getPlygons = Polygon::all();
          #polygon array
          $polygon=[]; 
          foreach ($getPlygons as $getPlygons)
          {
              $polygon[]= $getPlygons->lon;
              $polygon[]= $getPlygons->lat;
          }
          
          #impload polygon
          $implodePolygon = implode(" ", (array)$polygon);
         
          #new instance 
          $pointLocation = new PointLocation();

          #impload implode Points
          $implodePoints = implode( " ", [$request->long,$request->lat]);


          #points
          $points = array($implodePoints);
          #polygon
          $polygon = array($implodePolygon);

          #loop and send to check if point in polygon retuen boolean
          foreach($points as $key => $point) {

            $data = $pointLocation->pointInPolygon($point, $polygon);

           } 
          
            
        #if data == true
        if ($data == true) {

                return $this->returnSuccessMessage('location is valid', 200);

        } else {

            return $this->returnSuccessMessage('location is not valid', 200);

        }//end if 
    }//end function 


}//end class
