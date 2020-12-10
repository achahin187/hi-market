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

		$locations = City::all();

		return view($this->blade.__FUNCTION__)->with('locations',$locations);
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


    public function showPolygon($id)
    {
        $polygons = Polygon::Where('area_id',$id)->get();
    
        return view($this->blade.'show')->with('polygons', $polygons);
    }


    public function deleteArea($id)
    {
        $area = Area::find($id);
        if ($area) {

            $area->delete();
             return redirect()->back()->withStatus(__('delete_successfuly')); 
        }else{
           return redirect()->back()->withStatus(__('this Area not found')); 
        }
    }


   

}
