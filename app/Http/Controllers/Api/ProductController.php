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
use App\Models\Polygon;
use App\Models\Supermarket;
use App\Models\Udid;
use Illuminate\Http\Request;
use App\Http\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\HomeDataResource;
use App\Http\Resources\OfferResource;
use Carbon\Carbon;
use App\Polygons\PointLocation;
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
            "category_id" => "required"
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $product_count = Product::whereHas("branches", function ($query) {
            $query->where("branches.id", request("supermarket_id"));
        })->where(function ($q)
        {
            if(request("category_id") != 0 && \request("category_id"))
            {
                $q->where("category_id",\request("category_id"));
            }
        })->where("status","active")->where("flag",\request("is_offer",0))->filter()->count();
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
      

      
        $data = $this->checkPolygon($request->lat, $request->long);

        if ($data) {
       

            $getPolygon   = Polygon::where('lat', $data[1])->where('lon', $data[0])->first();
            $supermarkets = Branch::Where('city_id', $getPolygon->area->areacity->id)
                                   ->where('status', 'active')
                                   ->orderBy('priority', 'asc')
                                   ->limit(20)
                                   ->get();
          
                
            if (auth("client-api")->check()) {

                $client = Client::find(auth("client-api")->user()->id);
              
                if ($client && $request->lat && $request->long) {

                    $client->update([
                        'lat' => $request->lat,
                        'lon' => $request->long,
                    ]);
                

                    return $this->returnData(["supermarkets", "offers","isOffer","totalMoney"], [HomeDataResource::collection($supermarkets), OfferResource::collection($offers),!!$this->getOffer(),$this->getOffer()->total_order_money??0]);


                } else {

                    return $this->returnError(305, 'there is no client found');
                }
            } else {


                Udid::where("body", $request->header("udid"))->updateOrCreate([
                    "body" => $request->header("udid"),
                    'lat' => $request->lat,
                    'lon' => $request->long,

                ]);

                return $this->returnData(["supermarkets", "offers","isOffer", "totalMoney"], [HomeDataResource::collection($supermarkets), OfferResource::collection($offers),!!$this->getOffer(),$this->getOffer()->total_order_money??0]);
            }//end if 

        }else{

            $supermarkets = Branch::where('status', 'active')->orderBy('priority', 'asc')->limit(20)->inRandomOrder()->get();

            if (auth("client-api")->check()) {
                $client = auth("client-api")->user();

                if ($client) {

                    return $this->returnData(["supermarkets", "offers","isOffer","totalMoney"], [HomeDataResource::collection($supermarkets), OfferResource::collection($offers),!!$this->getOffer(),$this->getOffer()->total_order_money??0]);


                } else {

                    return $this->returnError(305, 'there is no client found');
                }
            } else {
                Udid::where("body", $request->header("udid"))->updateOrCreate([
                    "body" => $request->header("udid"),

                ]);

                return $this->returnData(["supermarkets", "offers","isOffer", "totalMoney"], [HomeDataResource::collection($supermarkets), OfferResource::collection($offers),!!$this->getOffer(),$this->getOffer()->total_order_money??0]);
            }//end if 
        }
    }

    public function homeSearch(Request $request)
    {
            $offers = Offer::Where('source','Delivertto')->where('status', 1)->orderBy('priority', 'asc')->get();
            if (auth("client-api")->check()) {

                $client = auth("client-api")->user();

                if ($client) {

                    $data = $this->checkPolygon($client->lat, $client->lon);

                    if ($data) {
                        

                        $getPolygon = Polygon::where('lat', $data[1])->where('lon', $data[0])->first();
                      // dd($request->name);
                        $supermarkets = Branch::Where('city_id', $getPolygon->area->areacity->id)
                                               ->where('status', 'active')
                                               ->where('name_en', 'LIKE', '%' . $request->name . "%")
                                               ->orWhere('name_ar', 'LIKE', '%' . $request->name . "%")         
                                               ->orderBy('priority', 'asc')
                                               ->limit(20)
                                               ->get();
                      

                        return $this->returnData(["supermarkets", "offers","isOffer","totalMoney"], [HomeDataResource::collection($supermarkets), OfferResource::collection($offers),!!$this->getOffer(),$this->getOffer()->total_order_money??0]);

                    }else{
                   
                          $supermarkets = Branch::where('status', 'active')
                                               ->where('name_en', 'LIKE', '%' . $request->name . "%")
                                               ->orWhere('name_ar', 'LIKE', '%' . $request->name . "%")         
                                               ->orderBy('priority', 'asc')
                                               ->limit(20)
                                               ->get();

                          return $this->returnData(["supermarkets", "offers","isOffer","totalMoney"], [HomeDataResource::collection($supermarkets), OfferResource::collection($offers),!!$this->getOffer(),$this->getOffer()->total_order_money??0]);

                    }//end of data

                } else {

                    $supermarkets = Branch::where('status', 'active')
                                               ->where('name_en', 'LIKE', '%' . $request->name . "%")
                                               ->orWhere('name_ar', 'LIKE', '%' . $request->name . "%")         
                                               ->orderBy('priority', 'asc')
                                               ->limit(20)
                                               ->get();

                return $this->returnData(["supermarkets", "offers","isOffer", "totalMoney"], [HomeDataResource::collection($supermarkets), OfferResource::collection($offers),!!$this->getOffer(),$this->getOffer()->total_order_money??0]);

                }//emd if client
            } else {
                Udid::where("body", $request->header("udid"))->updateOrCreate([
                    "body" => $request->header("udid"),

                ]);

                 $supermarkets = Branch::where('status', 'active')
                                               ->where('name_en', 'LIKE', '%' . $request->name . "%")
                                               ->orWhere('name_ar', 'LIKE', '%' . $request->name . "%")         
                                               ->orderBy('priority', 'asc')
                                               ->limit(20)
                                               ->get();

                return $this->returnData(["supermarkets", "offers","isOffer", "totalMoney"], [HomeDataResource::collection($supermarkets), OfferResource::collection($offers),!!$this->getOffer(),$this->getOffer()->total_order_money??0]);
            }//end if  auth
    }

    private function getOffer()
    {
        $offer = Offer::where('type','free delivery')->first();
        return $offer;
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
                "msg" => "Product Not Found"
            ], 404);
        }

        $product->update(["views" => $product->views == null ? 1 : $product->views + 1]);


        $product_details = Product::where('id', $product_id)->first();


        // $product_images = explode(',', $product->images);

        // $favproduct = DB::table('client_product')->where('udid', $request->header("udid"))->where('product_id', $product_id)->first();

        // $names = ['production_date', 'exp_date', 'measure', 'size'];

        // $values = [$product->production_date, $product->exp_date, 'kilo', !is_null($product->size) ? $product->size->value : 0];

        // $specifications = [];

        // for ($i = 0; $i < count($names); $i++) {
        //     array_push($specifications, array('name' => $names[$i], 'value' => $values[$i]));
        // }

        return $this->returnData(['product'], [new ProductDetailesResource($product_details)]);
        // if (isset($favproduct)) {
        //     $product_details->favourite = 1;
        // } else {
        //     $product_details->favourite = 0;
        // }

        // if ($product->flag == 1) {

        //     $offer_price = $product->offer_price;
        //     $price = $product->price;

        //     $product_details->offer = 1;
        //     $product_details->percentage = ($offer_price / $price) * 100;
        // } else {
        //     $product_details->offer = 0;
        // }

        // $imagepaths = [];

        // foreach ($product_images as $image) {
        //     array_push($imagepaths, asset('product_images/' . $image));
        // }

        // $product_details->imagepaths = $imagepaths;
        // $product_details->image = $imagepaths[0];
        // $product_details->ratings = $product->ratings;
        // $product_details->reviews = $product->clientreviews()->select('client_id', 'name', 'review')->get();
        // $product_details->specifications = $specifications;
        // $product_details->category = !is_null($product->category) ? $product->category->name_en : "";
        // $product_details->supermarket = !is_null($product->supermarket) ? $product->supermarket->eng_name : "";
        // $product_details->deliver_to = 'cairo';
        // $product_details->delivery_time = '30 minutes';


        
    }


   public function getproductsearch(Request $request)
    {

            $supermarket_id = $request->supermarket_id;
            $name = $request->name;
            $products = Product::orWhere('name_en', 'LIKE', '%' . $name . "%")
                               ->orWhere('name_ar', 'LIKE', '%' . $name . "%")
                                ->get();

            if (count($products) < 1) {

                 return response()->json([
                        'status' => true,
                        'msg' => '',
                        'data' => [],
                        ]);
            } else {

                $branches_ids = DB::table('product_supermarket')->WhereIn('Product_id',$products->pluck('id'))->where('branch_id', $supermarket_id)->get();

                return $this->returnData(['products'], [SearchResource::collection($branches_ids)]);

            }
    }



    public function filter()
    {

        $products = Product::whereHas("branches", function ($query) {

            $query->where("branches.id", request()->get("supermarket_id"));

        })->where("category_id", request()->get("category_id"))->filter()->paginate();

        return $this->returnData(["products"], [CategoryProductResource::collection($products)]);
    }

    private function checkPolygon($lat, $lon)
    {
         
          $getPlygons = Polygon::all();

          #polygon array        
          $polygons=[]; 
          foreach ($getPlygons as $getPlygons)
          {
              $polygons[$getPlygons->area_id][]= $getPlygons->lon .' '.$getPlygons->lat;
               
          }

          $Finalpolygons=[];
          foreach ($polygons as $index =>$polygon)
          {
             $Finalpolygons[] = $polygon;
               
          }
          #new instance 
          $pointLocation = new PointLocation();

          #impload implode Points
          $implodePoints = implode( " ", [$lon,$lat]);

          //$implodePolygon = implode( " ", $Finalpolygon);
          #points
          $point = array($implodePoints);

      
           $resultsList=[];
          foreach ($Finalpolygons as  $Finalpolygon) {
        
         
           $resultsList[] = $pointLocation->pointInPolygon($point, $Finalpolygon);

          }
          
        #if data == true
         $data = $this->checkLocation($resultsList);
         return $data;

    }//end function

     private function checkLocation($resultsList)
    {

          if (in_array(true, $resultsList)) {

              foreach ($resultsList as $data) {

                if($data == true){

       
                     return $data;
                }//end if 
              }
             
          }else{

            return false;

          }//end else
    }//end private function
}
