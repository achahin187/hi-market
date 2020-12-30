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
           $implodePolygon=[]; 
          #impload polygon
          foreach($polygon as $pol ){
          $implodePolygon[] = chunck($pol);

          }
          dd($implodePolygon);
         
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
       
        dd($data);
        #if data == true
        if ($data == true) {        

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
