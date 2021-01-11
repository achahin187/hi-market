<?php

namespace App\Http\Resources;

use App\Constants;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function getMessage($order)
    {
        $messages = [
            0 => "New Order Created",
            1 => "Your Order $order->num was Pending",
            2 => "Your Order $order->num Was Accepted",
            3 => "Your Order $order->num Was Process",
            4 => "Your Order $order->num Was Pickup",
            5 => "Your Order $order->num Was Delivered Rate Your Order",
            6 => "Your Order $order->num was Cancelled",
            null => ""
        ];

         return __("orders.messages",["num"=>$order->num])[$order->status];
    }

     public function getIcon($order)
    {
         $messages = [
            0 => asset('notification_icons/box.png'),
            1 => asset('notification_icons/box.png'),
            2 => asset('notification_icons/box.png'),
            3 => asset('notification_icons/box.png'),
            4 => asset('notification_icons/delivery-bike.png'),
            5 => asset('notification_icons/delivery-man.png'),
            6 => asset('notification_icons/box.png'),
            null => ""
        ];

         return $messages[$order->status];
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {   
        return [
            "id"    => $this->id,
            "title" => request()->header('lang') == 'ar' ? $this->title_ar : $this->title_en,
            "icon"  => $this->icon,
            "type"  => $this->type,
            "order_id"=> $this->order_id??null,
            "product_id"=> $this->product_id??null,
            "super_market_id"=> $this->supermarket_id??null,

        ];
    }
}
