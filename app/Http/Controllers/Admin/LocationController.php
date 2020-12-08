<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\City;
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
		$locations = City::WhereHas('locations')->get();

		return view($this->blade.__FUNCTION__)->with('locations',$locations);
	}


	public function create()
	{
		return view($this->blade.__FUNCTION__);
	}


    public function addLocation(request $request)
    {
    	 $locations =  collect (json_decode($request->data, true)) ;

    	 $count 	= 	$request->count;

    	 	
    	 if ($count < 5) {
    	 	return response()->json(['msg'=>'sorry you must add at least 5 polygons']);
    	 }else{

    	 foreach ($locations as $key => $location) {
    	 	
    	 	$store = Location::create([
    	 		'lat' => $location['lat'],
    	 		'lon' => $location['lng'],
    	 		'city_id' => 3,
    	 	]);
    	 }
    	 	return response()->json(['msg'=>'done']);

    	 }



    }
}
