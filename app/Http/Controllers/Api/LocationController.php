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
              $polygons[$getPlygons->area_id][]= $getPlygons->lon .' '.$getPlygons->lat;
               
          }


          //dd($polygons);

          $Finalpolygons=[];
          foreach ($polygons as $index =>$polygon)
          {
             $Finalpolygons[] = $polygon;
               
          }


            //dd($Finalpolygon);
       
          #new instance 
          $pointLocation = new PointLocation();

          #impload implode Points
          $implodePoints = implode( " ", [$request->long,$request->lat]);

          //$implodePolygon = implode( " ", $Finalpolygon);
          #points
          $point = array($implodePoints);

      
          foreach ($Finalpolygons as  $Finalpolygon) {
         
           $data = $pointLocation->pointInPolygon($point, $Finalpolygon);

          }

        #if data == true
        if ($data == true) {        

          $testPolygon = Polygon::where('lat', $data[1])->where('lon', $data[0])->first();
          dd($testPolygon->area->areacity->id);
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
