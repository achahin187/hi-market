<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\City;
use App\Models\Area;
use App\Models\Polygon;
use App\Polygons\PointLocation;
    
class LocationController extends Controller
{	
	public $blade;
	public $route;

	public function __construct()
	{
		$this->blade = 'Admin.locations.' ;
        $this->route = 'locations.' ;
	}

	public function index()
	{
        // $longitude =  ["30.792639641899","31.004856228806"]; //latitude of point to be checked

        // $All_lats = Polygon::all();
        // $check = new pointLocation($longitude,$All_lats);
         $pointLocation = new PointLocation();

$points = array("50 70");
$polygon = array("-50 30","50 70","100 50","80 10");
// The last point's coordinates must be the same as the first one's, to "close the loop"
foreach($points as $key => $point) {
    echo "point " . ($key+1) . " ($point): " . $pointLocation->pointInPolygon($point, $polygon) . "<br>";
}

        //$c = false; 
        // $vertices_x = [30.792639641899];  //latitude points of polygon
        // $vertices_y = [31.004856228806];   //longitude points of polygon

        // // foreach ($All_lats as  $lat) {
            
        // //    $vertices_x[] =   $lat->lat; 
        // //    $vertices_y[] =   $lat->lon; 
        // // }
        // //dd($vertices_x, $vertices_y);
        // $points_polygon = count($vertices_x); 
        // $longitude =  [30.792639641899]; //latitude of point to be checked
        // $latitude =  [31.004856228806]; //longitude of point to be checked

        // if ($this->is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude, $latitude)){
           
        //     echo "Is in polygon!"."<br>";
        // }
        // else { 
        //     echo "Is not in polygon"; 
        // }

		// $locations = City::WhereHas('locations')->get();

		// return view($this->blade.__FUNCTION__)->with('locations',$locations);
	}

    //   public function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y) {


    //     $i = $j = $c = 0;

    //     for ($i = 0, $j = $points_polygon-1; $i < $points_polygon; $j = $i++) {
    //         if (($vertices_y[$i] >  $latitude_y != ($vertices_y[$j] > $latitude_y)) && ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i])) {
    //             $c = !$c;
    //         }
    //     }
        
    //     return $c;
    // }


	public function getArea($id)
	{
		$areaLists = City::find($id)->areaList()->get();
		
		return view($this->blade.'area')->with('areaLists',$areaLists);
	}


	public function create()
	{	
		$cities = City::all();
		return view($this->blade.__FUNCTION__)->with('cities',$cities);
	}


    public function addLocation(request $request)
    {
    	 $locations =  collect (json_decode($request->data, true)) ;
    	 	
    	 if ($request->count < 5) {
    	 	return response()->json(['msg'=>'sorry you must add at least 5 polygons']);
    	 }else{


            $area = Area::create([
                'name_ar'     => $request->area_ar,
                'name_en'     => $request->area_en,
                'city'        => $request->city_id,
            ]);

    	 foreach ($locations as $key => $location) {
    	 	
    	 	$Polygon = Polygon::create([
    	 		'lat'     => $location['lat'],
    	 		'lon' 	  => $location['lng'],
    	 		'area_id' => $area->id,
    	 	]);
                
    	 }
    	 	return response()->json(['msg'=>'done']);

    	 }



    }

    public function status()
    {

        $area = Area::find(request()->id);

        if ($area) {
        	
        	$area->status === 'active' ?  $area->update(['status'=>'deactive']) :  $area->update(['status'=>'active']);

          return redirect()->back()->withStatus(__('status changed successfully'));

        }else{

          return redirect()->back()->withStatus(__('this id not found'));
        }

    }

}
