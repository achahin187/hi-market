<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\generaltrait;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    use generaltrait;

    public function clientorders($client_id)
    {
        $client = Client::find($client_id);

        if($client)
        {
            return $this->returnData('orders', $client->orders);
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
            return $this->returnData('order', $order);
        }
        else
        {
            return $this->returnError('','there is no client found');
        }
    }
}
