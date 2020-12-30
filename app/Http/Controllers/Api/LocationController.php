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
              $polygon[]= $getPlygons->lon .' '.$getPlygons->lat;
               
          }
         
           //$implodePolygon=[]; 
          #impload polygon
         
         // $implodePolygon = array_chunk($polygon,2);

       
          #new instance 
          $pointLocation = new PointLocation();

          #impload implode Points
          $implodePoints = implode( " ", [$request->long,$request->lat]);

          $implodePolygon = implode( " ", $polygon);
          #points
          $point = array($implodePoints);

      

          $data = $pointLocation->pointInPolygon($point, $polygon);

         
          dd($data);
       
        #if data == true
        if ($data == true || $data) {        

          $testPolygon = Polygon::where('lat', $data[0]['y'])->where('lon', $data[0]['x'])->first();
          $notTopic = Polygon::where('topic', '!=',$testPolygon->topic)->get();

                  return response()->json([
                    "status" => true,
                    'msg' =>'location is valid',
                    "data" => [
                        "topics" => $testPolygon->topic,
                        "nonTopic" => $notTopic->pluck('topic')->unique('topic'),
                     ]

        ]);

        } else {

            return response()->json([
             "status" => true,  
             'msg' =>'location is not valid',
           ], 404);

        }//end if 
    }
}
