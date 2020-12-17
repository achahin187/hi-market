<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\SimilarProductsResource;
use App\Http\Resources\CartResource;
use App\Http\Resources\CategoryProductResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductDetailesResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\WishlistResource;
use App\Http\Resources\GetReasonsResource;
use App\Http\Resources\MyOrdersResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Branch;
use App\Models\Reason;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\DeliveryCompany;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

class OrderController extends Controller
{
    //

    use GeneralTrait;

    public function __construct()
    {
        if (\request()->header("Authorization")) {
            $this->middleware("auth:client-api");
        }
    }

    // public function clientorders(Request $request)
    // {


    //     $client = getUser();

    //     if ($client) {

    //         if (count($client->orders) > 0) {
    //             return $this->returnData(['orders'], [OrderResource::collection($client->orders)]);
    //         } else {


    //             return $this->returnError(404, 'there is no orders for this client');
    //         }
    //     } else {

    //         return $this->returnError(404, 'there is no client found');
    //     }
    // }

    public function getorder($order_id)
    {
        $order = Order::find($order_id);

        if ($order) {
            return $this->returnData(['products'], [ProductDetailesResource::collection($order->products)]);
        } else {
            return $this->returnError('', 'there is no order found');
        }
    }


    public function addorder(Request $request)
    {


//        $device = Client_Device::where('udid', $udid)->first();


        $order_details = $request->all();

        $comapany = DeliveryCompany::WhereHas('branches', function ($q) use ($request) {
            $q->Where('branch_id', $request->branch_id);
        })->first();

        $client = getUser();

        $date = now();

        $date = $date->addDays($request->day_index - 1);


        if ($client) {

            if (request("asap") == 0) {
                $order_details["delivery_date"] = $date->format("Y-m-d g:i A");
            } else {

                $order_details["delivery_date"] = $date->addHours(\request("hours_index"))->format("Y-m-d g:i A");
            }

            $order = Order::create([

                'num' => "sdsadf3244",
                'client_id' => $client->id,
                'restId' => $order_details["rest_id"],
                'address' => $order_details["address"],
                'lat' => $order_details["lat"],
                'long' => $order_details["long"],
                'delivery_date' => $order_details["delivery_date"],
                'delivery_fees' => $order_details["delivery_fees"],
                'coupon' => $order_details["coupon"],
                'discount' => $order_details["discount"],
                'status' => 0,
                'final_total' => $order_details["final_total"],
                'company_id' => $comapany->id
            ]);


            $comapany->orders()->attach([
                'order_id' => $order->id,
                'company_id' => $comapany->id,
            ]);


            return $this->returnSuccessMessage('The order has been completed successfully', 200);

        } else {

            return $this->returnError(404, 'something wrong happened');

        }
    }

    public function addcart(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            "category_ids" => "required",
            "supermarket_id" => "required",
            "products" => "required"

        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }
        $udid = $request->header('udid');
        $user = getUser();
        if (!$user) {
            return $this->returnError(422, "user not exists");
        }


        $category_ids = explode(",", $request->category_ids);

        $categories = $category_ids;

        $supermarket_id = $request->supermarket_id;


        $fav_ids = [];

        $favproducts = DB::table('client_product')->where('udid', $udid)->select('product_id')->get();

        $similar_products = Product::similar($categories, $supermarket_id)->get();

    


        foreach ($favproducts as $product) {
            array_push($fav_ids, $product->product_id);
        }

        $setting = Setting::select('delivery')->first();


        $wishlist = Product::whereIn('id', $fav_ids)->whereHas("branches", function ($query) {
            $query->where("branches.id", request("supermarket_id"));
        })->get();

        $cart = collect([]);

        foreach (explode(",", request("products")) as $index => $product) {

            $cart->add(Cart::create([
                "user_id" => getUser()->id,
                "product_id" => explode(":", $product)[0],
                "qty" => explode(":", $product)[1],
            ]));
        }
        

        $cart = $cart->filter(function ($cart) {
            return $cart->product != null;
        });
        return $this->returnData(['similar products', 'wishlist', 'setting', "cart"], [
            SimilarProductsResource::collection($similar_products)
            , WishlistResource::collection($wishlist)
            , $setting->delivery ?? 0
            , CartResource::collection($cart)
        ]);

    }

    public function selectDate()
    {
        $branch = Branch::find(request("supermarket_id"));
        $days = [
            [
                "id" => 1,
                "text" => "Today",
            ],
            [
                "id" => 2,
                "text" => "Tomorrow"
            ],
            [
                "id" => 3,
                "text" => now()->addDays(2)->format("l")
            ],
            [
                "id" => 4,
                "text" => now()->addDays(3)->format("l")
            ]

        ];
        $time = [];
        for ($i = 0; $i < 10; $i++) {
            $time[$i] = [
                "id" => $i + 1,
                "text" => now()->addHours($i)->format("g A")
            ];
        }


        return $this->returnData(["days", "time", "state"], [$days, $time, $this->getState($branch)]);
    }

    public function getState($branch)
    {

        $now = now();
        $start_time = Carbon::parse($branch->start_time)->format("H:i:s");
        $end_time = Carbon::parse($branch->end_time)->format("H:i:s");
                if ($now >= $start_time && $now <= $end_time) {

                    return 'open';

                } else {
                    return 'closed';

                }
    }

    public function getClientOrder(Request $request)
    {
        $udid = $request->header('udid');

        $client = getUser();

        if ($client) {

            $clientOrders = $client->orders;

           


                return MyOrdersResource::collection($clientOrders);

           

        } else {

            return $this->returnError(422, "user not exists");

        }
    }

    public function getReasons()
    {
        $reasons = Reason::Where('status','active')->get();

        return $this->returnData(['reasons'], [GetReasonsResource::collection($reasons)]);
        
    }

    public function CancelOrder(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            "order_id" => "required",
            "reason_id" => "required",
        ]);
        if ($validation->fails()) {
            return $this->returnValidationError(422, $validation);
        }

        $getOrder = Order::find($request->id);

        if ($getOrder) {

            $getOrder->update(['status'=>5, 'resone_id'=>$reqeust->reason_id]);

            return $this->returnSuccessMessage('order Canceled successfully', 200);

        }else{
            
            return $this->returnError(404, "This order id not found");
        }


    }
}
