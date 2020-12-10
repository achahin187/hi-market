<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Product;
use App\Models\Vendor;


class VendorController extends Controller
{
    use GeneralTrait;

    public function show()
    {

        $vendors = Vendor::whereHas("categories", function ($query) use ($id) {
            $query->where("categories.id", request("category_id"));
        })->get();

        return $this->returnData(["vendors"], [VendorResource::collection($vendors)]);
    }

}
