<?php

namespace App\Http\Controllers\Api;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\CategoryProductResource;
use App\Http\Resources\OrderResource;
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
            return $this->returnData(['products'], [ProductResource::collection($order->products)]);
        } else {
            return $this->returnError('', 'there is no order found');
        }
    }


    public function addorder(Request $request)
    {


//        $device = Client_Device::where('udid', $udid)->first();


        $order_details = $request->all();


        $client = getUser();


        if ($client) {

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
            "category_ids" => "required|array",
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


        $category_ids = $request->category_ids;

        $categories = $category_ids;

        $supermarket_id = $request->supermarket_id;


        $imagepaths = [];

        $fav_ids = [];

        $favproducts = DB::table('client_product')->where('udid', $udid)->select('product_id')->get();


        $similar_products = Product::similar($categories, $supermarket_id)->get();


        foreach ($similar_products as $product) {

            $product_images = explode(',', $product->images);

            foreach ($product_images as $image) {
                array_push($imagepaths, asset('images/' . $image));
            }

            $product->imagepaths = $imagepaths;

        }

        foreach ($favproducts as $product) {
            array_push($fav_ids, $product->product_id);
        }

        $setting = Setting::select('delivery')->first();


        $wishlist = Product::whereIn('id', $fav_ids)->where('supermarket_id', $supermarket_id)->get();

        $products = Product::find($request->products);
        return $this->returnData(['similar products', 'wishlist', 'setting', "cart"], [ProductResource::collection($similar_products), WishlistResource::collection($wishlist), $setting->delivery, CategoryProductResource::collection($products)]);

    }
    public function selectDate()
    {
        
    }

}
