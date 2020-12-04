<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
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

    use generaltrait;

    public function __construct()
    {
        if (\request()->header("Authorization")) {
            $this->middleware("auth:client-api");
        }
    }

    public function clientorders(Request $request)
    {

        $udid = $request->header('udid');

        $token = $request->header('token');

        $lang = $request->header('lang');

        if (!$lang || $lang == '') {

            return $this->returnError(402, 'language is missing');
        }

        $client = Client::where('remember_token', $token)->first();

        if ($client) {

            if (count($client->orders) > 0) {

                return $this->returnData(['orders'], [$client->orders]);
            } else {

                if ($lang == 'ar') {
                    return $this->returnError(305, 'لا يوجد طلبات لهذا العميل');
                }
                return $this->returnError(305, 'there is no orders for this client');
            }
        } else {
            if ($lang == 'ar') {
                return $this->returnError(305, 'لم نجد هذا العميل');
            }
            return $this->returnError(305, 'there is no client found');
        }
    }

    public function getorder($order_id)
    {
        $order = Order::find($order_id);

        if ($order) {
            return $this->returnData('order', $order->products);
        } else {
            return $this->returnError('', 'there is no order found');
        }
    }


    public function addorder(Request $request)
    {


//        $device = Client_Device::where('udid', $udid)->first();


        $order_details = json_decode($request->getContent());


        $client = getUser();


        if ($client) {

            $order = Order::create([

                'num' => "sdsadf3244",
                'client_id' => $client->id,
                'restId' => $order_details->rest_id,
                'address' => $order_details->address,
                'lat' => $order_details->lat,
                'long' => $order_details->long,
                'delivery_date' => $order_details->date,
                'delivery_fees' => $order_details->delivery_fees,
                'coupon' => $order_details->coupon,
                'discount' => $order_details->discount,
                'status' => 0,
                'final_total' => $order_details->final_total
            ]);


            foreach ($order_details->products as $product) {

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


        $udid = $request->header('udid');

        $category_ids = $request->category_ids;

        $categories = explode(',', $category_ids);

        $supermarket_id = $request->supermarket_id;

        $client = getUser();


        $imagepaths = [];

        $fav_ids = [];

        $favproducts = DB::table('client_product')->where('udid', $udid)->select('product_id')->get();


        $similar_products = Product::whereIn('category_id', $categories)->where('supermarket_id', $supermarket_id)->select('id', 'images')->get();


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


        $wishlist = Product::whereIn('id', $fav_ids)->where('supermarket_id', $supermarket_id)->select('id', 'name_' . app()->getLocale() . ' as name', 'arab_description as description', 'price', 'offer_price', 'images', 'rate', 'flag', 'ratings', 'category_id', 'supermarket_id')->get();


        foreach ($wishlist as $product) {


            $offer_price = $product->offer_price;
            $price = $product->price;

            $product->percentage = ($offer_price / $price) * 100;

            $product->imagepath = asset('images/' . $product->images);


            $product->categoryname = $product->category->name;
            $product->supermarketname = $product->supermarket->name;

        }


        if ($client) {
            return $this->returnData(['similar products'], [$similar_products]);
        }


        return $this->returnData(['similar products', 'wishlist', 'setting'], [$similar_products, $wishlist, $setting->delivery]);

    }

}
