<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\DeliveryCompany;


class VendorController extends Controller
{
    use GeneralTrait;

    public function show()
    {

        $vendors = Vendor::whereHas("categories", function ($query)  {
            $query->where("categories.id", request("category_id"));
        })->has("products")->get();

        return $this->returnData(["vendors"], [VendorResource::collection($vendors)]);
    }

   

    public function distance($lat1, $lon1, $lat2, $lon2) { 

		$pi80 = M_PI / 180; 
		$lat1 *= $pi80; 
		$lon1 *= $pi80; 
		$lat2 *= $pi80; 
		$lon2 *= $pi80; 
		$r = 6372.797; // mean radius of Earth in km 
		$dlat = $lat2 - $lat1; 
		$dlon = $lon2 - $lon1; 
		$a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlon / 2) * sin($dlon / 2); 
		$c = 2 * atan2(sqrt($a), sqrt(1 - $a)); 
		$km = $r * $c; 
		//echo ' '.$km; 
		return $km; 

	}
}
