<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\City;
use App\Models\Area;
use App\Models\Polygon;
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

        $All_lats = Polygon::all();
        $c = false; 
        $vertices_x = array();  //latitude points of polygon
        $vertices_y = array();   //longitude points of polygon

        foreach ($All_lats as  $lat) {
            
           $vertices_x[] =   $lat->lat; 
           $vertices_y[] =   $lat->lon; 
        }
        //dd($vertices_x, $vertices_y);
        $points_polygon = count($vertices_x); 
        $longitude =  30.792639641899; //latitude of point to be checked
        $latitude =  31.010306477524; //longitude of point to be checked

        if ($this->is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude, $latitude)){
            echo "Is in polygon!"."<br>";
        }
        else { 
            echo "Is not in polygon"; 
        }

		// $locations = City::WhereHas('locations')->get();

		// return view($this->blade.__FUNCTION__)->with('locations',$locations);
	}

      public function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y) {
        $i = $j = $c = 0;

        for ($i = 0, $j = $points_polygon-1; $i < $points_polygon; $j = $i++) {
            if (($vertices_y[$i] >  $latitude_y != ($vertices_y[$j] > $latitude_y)) && ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i])) {
                $c = !$c;
            }
        }
        dd($c);
        return $c;
    }


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
