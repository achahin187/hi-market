<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryProductResource;
use App\Http\Resources\ProductDetailesResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SearchResource;
use App\Models\Client;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Supermarket;
use App\Models\Udid;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\HomeDataResource;
use App\Http\Resources\OfferResource;
use Carbon\Carbon;

class ProductController extends Controller
{
    //

    use GeneralTrait;

    public function __construct()
    {
        if (\request()->header("Authorization")) {
            $this->middleware("auth:client-api");
        }
    }
    #vendor
    #new arrival 
    public function productCount()
    {
        $validation = \Validator::make(request()->all(), [
            "supermarket_id" => "required|exists:branches,id",
            "category_id" => "required|exists:categories,id"
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $product_count = Product::whereHas("branches", function ($query) {
            $query->where("branches.id", request("supermarket_id"));
        })->where("category_id", request("category_id"))->filter()->count();
        return $this->returnData(["product_count"], [$product_count]);
    }

    public function homedata(Request $request)
    {
        // Add Rate And Address Branch ++.
        // Change to Branch
        $checkSatus  = Offer::where('end_date', '<', Carbon::now()->format('Y-m-d H:i')  )->get();
      
        foreach ($checkSatus as  $status) {
            $status->update(['status'=> 0]);
        }

        $offers = Offer::Where('source','Delivertto')->where('status', 1)->orderBy('priority', 'asc')->get();

        $supermarkets = Branch::where('status', 'active')->orderBy('priority', 'asc')->limit(20)->get();



        foreach ($supermarkets as $supermarket) {
            $supermarket->imagepath = $supermarket->image ?  asset('images/' . $supermarket->image) : asset("images/default.svg");
            $supermarket->logopath = asset('images/' . $supermarket->logo);
            //$supermarket->town = $supermarket->city->name;
        }

        foreach ($offers as $offer) {
            $offer->imagepath = asset('images/' . $offer->image);
        }

        if (auth("client-api")->check()) {
            $client = auth("client-api")->user();

            if ($client) {

                return $this->returnData(["supermarkets", "offers"], [HomeDataResource::collection($supermarkets), OfferResource::collection($offers)]);


            } else {

                return $this->returnError(305, 'there is no client found');
            }
        } else {
            Udid::where("body", $request->header("udid"))->updateOrCreate([
                "body" => $request->header("udid"),

            ]);

            return $this->returnData(["supermarkets", "offers"], [HomeDataResource::collection($supermarkets), OfferResource::collection($offers)]);
        }
    }

    public function productdetails(Request $request)
    {

        $validation = \Validator::make($request->all(), [
            "id"             => "required",
            "supermarket_id" => "required",
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $product_id = $request->id;
        try {

            $product = Product::findOrFail($product_id);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "status" => "Product Not Found"
            ], 404);
        }

        $product->update(["views" => $product->views == null ? 1 : $product->views + 1]);


        $product_details = Product::where('id', $product_id)->first();


        $product_images = explode(',', $product->images);

        $favproduct = DB::table('client_product')->where('udid', $request->header("udid"))->where('product_id', $product_id)->first();

        $names = ['production_date', 'exp_date', 'measure', 'size'];

        $values = [$product->production_date, $product->exp_date, 'kilo', !is_null($product->size) ? $product->size->value : 0];

        $specifications = [];

        for ($i = 0; $i < count($names); $i++) {
            array_push($specifications, array('name' => $names[$i], 'value' => $values[$i]));
        }

        if (isset($favproduct)) {
            $product_details->favourite = 1;
        } else {
            $product_details->favourite = 0;
        }

        if ($product->flag == 1) {

            $offer_price = $product->offer_price;
            $price = $product->price;

            $product_details->offer = 1;
            $product_details->percentage = ($offer_price / $price) * 100;
        } else {
            $product_details->offer = 0;
        }

        $imagepaths = [];

        foreach ($product_images as $image) {
            array_push($imagepaths, asset('product_images/' . $image));
        }

        $product_details->imagepaths = $imagepaths;
        $product_details->image = $imagepaths[0];
        $product_details->ratings = $product->ratings;
        $product_details->reviews = $product->clientreviews()->select('client_id', 'name', 'review')->get();
        $product_details->specifications = $specifications;
        $product_details->category = !is_null($product->category) ? $product->category->name_en : "";
        $product_details->supermarket = !is_null($product->supermarket) ? $product->supermarket->eng_name : "";
        $product_details->deliver_to = 'cairo';
        $product_details->delivery_time = '30 minutes';


        return $this->returnData(['product'], [new ProductDetailesResource($product_details)]);
    }

    public function getproductsearch(Request $request)
    {


            $products = Product::where('name_en', 'LIKE', '%' . $request->name . "%")->orWhere('name_ar', 'LIKE', '%' . $request->name . "%")->get();


            if (count($products) < 1) {

                 return response()->json([
                        'status' => true,
                        'msg' => '',
                        'data' => [],
                        ]);
            } else {

                $branches_ids = DB::table('product_supermarket')->WhereIn('Product_id',$products->pluck('id'))->get();

                return $this->returnData(['products'], [SearchResource::collection($branches_ids)]);

                // $search_result = Product::WhereHas('branches', function ($q) use ($branches_ids){
                //     $q->WhereIn('branches.id',$branches_ids);
                // })->get();

            //return $search_result;
            // return [
            //     'status' =>true,
            //     'msg' =>'',
            //     'products' =>SearchResource::collection($branches_ids),
            // ];

                // foreach ($search_result as $product) {

                //     if ($this->getCurrentLang() == 'ar') {
                       
                //         $productarray =
                //             [
                //                 'id' => $product->id,
                //                 'name' => $product->name_ar,
                //                 'description' => $product->arab_description,
                //                 'rate' => $product->rate,
                //                 'supermarketId'=> $product->branch_id,
                //                 'price' => $product->price,
                //                 'offer_price' => $product->offer_price,
                //                 'images' => asset('product_images/'.$product->images),
                //                 'points' => $product->points,
                //                 'category' => !is_null($product->category) ? $product->category->name_ar : "",
                //                 'vendor' => !is_null($product->vendor) ? $product->vendor->arab_name : ""
                //             ];
                //     } else {

                //         $productarray =
                //             [
                //                 'id' => $product->id,
                //                 'name' => $product->name_en,
                //                 'description' => $product->eng_description,
                //                 'rate' => $product->rate,
                //                 'supermarketId'=> $product->branch_id,
                //                 'price' => $product->price,
                //                 'offer_price' => $product->offer_price,
                //                 'images' => asset('product_images/'.$product->images),
                //                 'points' => $product->points,
                //                 'category' => !is_null($product->category) ? $product->category->name_en : "",
                //                 'vendor' => !is_null($product->vendor) ? $product->vendor->eng_name : ""
                //             ];
                //     }
                //     $all_products [] = $productarray;
                // }
                
            }    
    }

    public function filter()
    {

        $products = Product::whereHas("branches", function ($query) {

            $query->where("branches.id", request()->get("supermarket_id"));

        })->where("category_id", request()->get("category_id"))->filter()->paginate();

        return $this->returnData(["products"], [CategoryProductResource::collection($products)]);
    }
}
