<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Traits\generaltrait;
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

    use generaltrait;

    public function __construct()
    {
        if (request()->header("Authorization")) {
            $this->middleware("auth:client-api");
        }
    }

    public function supermarketcategories(Request $request)
    {


        $client = auth("client-api")->user();

        $supermarket_id = $request->id;

        try {
            $supermarket = Branch::findOrFail($supermarket_id);

        } catch (\Exception $exception) {
            return $this->returnError(404, "SuperMarket Not Found");
        }


        $categories = $supermarket->categories()
        ->select('categories.id',
         'name_'.app()->getLocale().' as name',
          'image')
        ->get();


        $supermarketname = Branch::where('id', $supermarket_id)->select('name_'.app()->getLocale().' as name')->first();

        $offers = offer::where('status', 'active')->where('supermarket_id', $supermarket_id)->select('id', 'arab_name as name', 'arab_description as description', 'promocode', 'offer_type', 'value_type', 'image')->where('supermarket_id', $supermarket_id)->limit(4)->get();


        foreach ($categories as $category) {
            $category->imagepath = asset('images/' . $category->image);
        }

        foreach ($offers as $offer) {
            $offer->imagepath = asset('images/' . $offer->image);
        }


        return $this->returnData(['categories', 'offers', 'supermarket'], [$categories, $offers, $supermarketname]);


    }


    public function supermarketoffers(Request $request)
    {


        $udid = $request->header('udid');

        $supermarket_id = $request->supermarket_id;
        try {

            $supermarket = supermarket::findOrFail($supermarket_id);
        } catch (\Exception $e) {
            return $this->returnError(404, "Super Market Not Found");
        }

        $favproducts = DB::table('client_product')->where('udid', $udid)->select('product_id')->get();


        $products = $supermarket->products()->where('status', 'active')->where('flag', 1)->get();

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


        return $this->returnData(['products'], [$products]);


    }

    public function categoryproducts(Request $request)
    {

        $udid = $request->header('udid');


        $category_id = $request->category_id;

        $favproducts = DB::table('client_product')->where('udid', $udid)->select('product_id')->get();


        if ($category_id) {

            $category = Category::find($category_id);

            if ($category) {


                $products = $category->products()->where('status', 'active')->get();


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
                    $price = $product->price;

                    $product->percentage = ($offer_price / $price) * 100;

                    $product->imagepath = asset('images/' . $product->images);


                    $product->categoryname = $product->category->{"name_" . app()->getLocale()};

                }


                return response()->json([
                    "status"=>true,
                   "msg"=>"",
                   "data"=>[
                       "products"=>ProductResource::collection($products)
                   ]
                ]);


            }
        }
    }
}
