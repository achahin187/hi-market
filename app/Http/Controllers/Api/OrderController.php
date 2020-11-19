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

    public function clientorders(Request $request)
    {

        $udid = $request->header('udid');

        $token = $request->header('token');

        $lang = $request->header('lang');

        if(!$lang || $lang == ''){

            return $this->returnError(402,'language is missing');
        }

        $client = Client::where('remember_token', $token)->first();

        if($client)
        {

            if(count($client->orders) > 0) {

                return $this->returnData(['orders'], [$client->orders]);
            }
            else
            {

                if ($lang == 'ar') {
                    return $this->returnError(305,'لا يوجد طلبات لهذا العميل');
                }
                return $this->returnError(305, 'there is no orders for this client');
            }
        }
        else
        {
            if ($lang == 'ar') {
                return $this->returnError(305, 'لم نجد هذا العميل');
            }
            return $this->returnError(305, 'there is no client found');
        }
    }

    public function getorder($order_id)
    {
        $order = Order::find($order_id);

        if($order)
        {
            return $this->returnData('order', $order->products);
        }
        else
        {
            return $this->returnError('','there is no order found');
        }
    }


    public function addorder(Request $request)
    {

        $token = $request->header('token');

        $lang = $request->header('lang');

        $udid = $request->header('udid');


        if (!$lang || $lang == '') {
            return $this->returnError(402, 'language is missing');
        }

        $device = Client_Devices::where('udid', $udid)->first();


        if (!$lang || $lang == '') {
            return $this->returnError(402, Lang::get('message.missingLang'));
        }

        $order_details = json_decode($request->getContent());


        if($token) {

            $client = \App\Model\Client::where('remember_token',$token)->first();


            if($client) {

                $order = \App\Model\Order::create([

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
            }

        }


        if($order)
        {


            foreach($order_details->products as $product)
            {

                $order->products()->attach($product->id,['quantity' => $product->quantity, 'price' => $product->price]);

                if($order_details->flag == 1) {

                    foreach ($product->addons as $addon) {
                        $order->productaddons()->attach($addon->id, ['quantity' => $addon->quantity, 'price' => $addon->price]);
                    }
                }

            }

            if ($lang == 'ar') {
                return $this->returnSuccessMessage('لقد تم إضافةالطلب', 500);
            }
            else
            {
                return $this->returnSuccessMessage('The order has been completed successfully' , 500);
            }
        }
        else
        {
            if ($lang == 'ar') {
                return $this->returnError(300, 'هناك خطأ ما');
            }
            else
            {
                return $this->returnError(300, 'something wrong happened');
            }
        }
    }

    public function addcart(Request $request)
    {

        $token = $request->header('token');

        $lang = $request->header('lang');

        $udid = $request->header('udid');

        $category_ids = $request->category_ids;

        $categories = explode(',',$category_ids);

        $supermarket_id = $request->supermarket_id;


        if (!$lang || $lang == '') {
            return $this->returnError(402, 'language is missing');
        }

        $category_ids = $request->category_ids;

        $imagepaths = [];

        $fav_ids = [];

        $favproducts = DB::table('client_product')->where('udid',$udid)->select('product_id')->get();


        if ($lang == 'ar') {
            $similar_products = Product::whereIn('category_id',$categories)->where('supermarket_id',$supermarket_id)->select('id','images')->get();
        } else {
            $similar_products = Product::whereIn('category_id',$categories)->where('supermarket_id',$supermarket_id)->select('id','images')->get();
        }

        foreach ($similar_products as $product) {

            $product_images = explode(',',$product->images);

            foreach ($product_images as $image) {
                array_push($imagepaths, asset('images/' . $image));
            }

            $product->imagepaths = $imagepaths;

        }

        foreach ($favproducts as $product)
        {
            array_push($fav_ids, $product->product_id);
        }

        $setting = Setting::select('delivery')->first();

        if ($lang == 'ar') {
            $wishlist = Product::whereIn('id',$fav_ids)->select('id', 'name_' . $lang . ' as name', 'arab_description as description', 'price','offer_price','images','rate','flag','ratings','category_id','supermarket_id')->get();
        } else {
            $wishlist = Product::whereIn('id',$fav_ids)->select('id', 'name_' . $lang . ' as name', 'arab_description as description', 'price','offer_price','images','rate','flag','ratings','category_id','supermarket_id')->get();
        }

        foreach ($wishlist as $product) {


            $offer_price = $product->offer_price;
            $price = $product->price;

            $product->percentage = ($offer_price / $price) * 100;

            $product->imagepath = asset('images/' . $product->images);

            if($lang == 'ar')
            {
                $product->categoryname = $product->category->name_ar;
                $product->supermarketname = $product->supermarket->arab_name;
            }
            else
            {
                $product->categoryname = $product->category->name_en;
                $product->supermarketname = $product->supermarket->eng_name;
            }
        }

        if ($token) {

            $client = Client::where('remember_token', $token)->first();

            if ($client) {
                return $this->returnData(['similar products'], [$similar_products]);
            } else {
                if ($lang == 'ar') {
                    return $this->returnError(305, 'لم نجد هذا العميل');
                }
                return $this->returnError(305, 'there is no client found');
            }

        } else {
            return $this->returnData(['similar products','wishlist','setting'], [$similar_products,$wishlist,$setting->delivery]);
        }
    }

}
