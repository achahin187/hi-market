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

    public function show($id)
    {
        $validation = \Validator::make(request()->all(), [
            "supermarket_id" => "required|exists:branches,id",
            "category_id" => "required|exists:categories,id"

        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $vendors = Vendor::whereHas("categories", function ($query) use ($id) {
            $query->where("categories.id", $id);
        })->get();
        $product_count = Product::where("branches", function ($query) {
            $query->where("branches.id", request("supermarket_id"));
        })->where("category_id", request("category_id"))->filter()->count();
        return $this->returnData(["vendors", "product_count"], [VendorResource::collection($vendors), $product_count]);
    }

}
