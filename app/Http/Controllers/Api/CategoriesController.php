<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryProductResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\ProductResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Category;
use App\Models\Client;
use App\Models\Branch;
use App\Models\Offer;
use App\Models\Supermarket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    //

    use GeneralTrait;

    public function __construct()
    {
        if (request()->header("Authorization")) {
            $this->middleware("auth:client-api");
        }
    }

    public function supermarketcategories(Request $request)
    {


        $branch_id = $request->id;

        try {
            $branch = Branch::findOrFail($branch_id);

        } catch (\Exception $exception) {
            return $this->returnError(404, "SuperMarket Not Found");
        }


        $categories = $branch->categories()->get();


        $branchname = Branch::where('id', $branch_id)->first();

        $offers = offer::where('status', 'active')->where('branch_id', $branch_id)->limit(4)->get();


        foreach ($categories as $category) {
            $category->imagepath = asset('images/' . $category->image);
        }

        foreach ($offers as $offer) {
            $offer->imagepath = asset('images/' . $offer->image);
        }


        return response()->json([
            "status" => true,
            "data" => [
                "categories" => CategoryResource::collection($categories),
                "offers" => OfferResource::collection($offers),
                "supermarket" => [
                    'id' => $branch->id,
                    "name" => $branch->name,
                ]
            ]

        ]);


    }


    public function supermarketoffers(Request $request)
    {

        $validation = \Validator::make($request->all(), [
            "supermarket_id" => "required",

        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $udid = $request->header('udid');

        $supermarket_id = $request->supermarket_id;
        try {

            $supermarket = Branch::findOrFail($supermarket_id);
        } catch (\Exception $e) {
            return $this->returnError(404, "Super Market Not Found");
        }

        $favproducts = DB::table('client_product')
            ->where('udid', $udid)
            ->where("supermarket_id", $request->supermarket_id)
            ->select('product_id')->get();


        $products = $supermarket->products()->has("category")->filter()->where('status', 'active')->where('flag', 1)->get();

        foreach ($products as $product) {

            $product->favourite = 0;

            if (count($favproducts) > 0) {
                foreach ($favproducts as $favproduct) {
                    if ($product->id == $favproduct->product_id) {
                        $product->favourite = 1;
                    }
                }
            }


            $offer_price = $product->offer_price;

            $product->offer = $product->offer_price;

            $price = $product->price;

            $product->percentage = ($offer_price / $price) * 100;

            $product->imagepath = asset('images/' . $product->images);


            $product->categoryname = $product->category->{"name_" . app()->getLocale()};


        };


        return $this->returnData(['products'], [CategoryProductResource::collection($products)]);


    }

    public function categoryproducts(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            "supermarket_id" => "required",
            "category_id" => "required"
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $udid = $request->header('udid');


        $category_id = $request->category_id;

        $favproducts = DB::table('client_product')->where('udid', $udid)->select('product_id')->get();


        if ($category_id) {

            $category = Category::find($category_id);

            if ($category) {


                $products = $category->products()->whereHas("branches",function($query){
                    $query->where("branches.id",request("supermarket_id"));
                })->whereNotNull("created_at")->has("category")->filter()->where('status', 'active')->get();


                foreach ($products as $product) {

                    $product->favourite = 0;

                    if (count($favproducts) > 0) {

                        foreach ($favproducts as $favproduct) {
                            if ($product->id == $favproduct->product_id) {
                                $product->favourite = 1;
                            }
                        }
                    }


                    $product->imagepath = asset('images/' . $product->images);


                }


                return response()->json([
                    "status" => true,
                    "msg" => "",
                    "data" => [
                        "products" => CategoryProductResource::collection($products)
                    ]
                ]);

            }
        }
        return $this->returnError(422, "Pass category id");

    }
}
