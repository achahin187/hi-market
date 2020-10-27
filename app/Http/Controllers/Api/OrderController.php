<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class OrderController extends Controller
{
    //

    use generaltrait;

    public function clientorders($client_id)
    {
        $client = Client::find($client_id);

        if($client)
        {
            if(count($client->orders) > 0) {

                return $this->returnData('orders', $client->orders);
            }
            else
            {
                return $this->returnError('','there is no orders for this client');
            }
        }
        else
        {
            return $this->returnError('','there is no client found');
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
}
