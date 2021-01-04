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
          $polygons=[]; 
          foreach ($getPlygons as $getPlygons)
          {
              $polygons[$getPlygons->area_id][]= $getPlygons->lon .' '.$getPlygons->lat;
               
          }

          $Finalpolygons=[];
          foreach ($polygons as $index =>$polygon)
          {
             $Finalpolygons[] = $polygon;
               
          }

          #new instance 
          $pointLocation = new PointLocation();
          #impload implode Points
          $implodePoints = implode( " ", [$request->long,$request->lat]);
          #points
          $point = array($implodePoints);
          
          $resultsList=[];
          foreach ($Finalpolygons as  $Finalpolygon) {
        
         
           $resultsList[] = $pointLocation->pointInPolygon($point, $Finalpolygon);

          }
         $data = $this->checkLocation($resultsList);
         
        #if data == true
        if ($data) {        
      
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

    private function checkLocation($resultsList)
    {

          if (in_array(true, $resultsList)) {

              foreach ($resultsList as $data) {

                if($data == true){

                     return $data;
                }
              }
             
          }else{
            return false;
          }
    }
}
