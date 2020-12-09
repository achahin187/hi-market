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
use App\Http\Traits\GeneralTrait;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
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

    public function clientorders(Request $request)
    {

        $client = getUser();

        if ($client) {

            if (count($client->orders) > 0) {

                return $this->returnData(['orders'], [OrderResource::collection($client->orders)]);
            } else {


                return $this->returnError(404, 'there is no orders for this client');
            }
        } else {

            return $this->returnError(404, 'there is no client found');
        }
    }

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


        $client = getUser();

        $date = now();
//        if ($request->day_index == 2) {
//            $date = $date->addDays(1);
//        } else if ($request->day_index == 3) {
//            $date = $date->addDays(2);
//        } elseif ($request->day_index == 4) {
//            $date = $date->addDays(3);
//        }


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
                'final_total' => $order_details["final_total"]
            ]);


            foreach (Product::find($order_details["products"]) as $product) {

                $order->products()->attach($product->id, ['quantity' => $product->quantity, 'price' => $product->price]);

                if ($order_details->flag == 1) {

                    foreach ($product->addons as $addon) {
                        $order->productaddons()->attach($addon->id, ['quantity' => $addon->quantity, 'price' => $addon->price]);
                    }
                }

            }


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
        foreach (explode(",", request("products")) as $product) {
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
                "id" => $i,
                "text" => now()->addHours($i)->format("g A")
            ];
        }
        $state = [
            1 => "close",
            2 => "open"
        ];
        return $this->returnData(["days", "time", "state"], [$days, $time, $state[rand(1, 2)]]);
    }

}
