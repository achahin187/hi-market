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
            Constants::ORDER_NEW => "New Order Created",
            Constants::ORDER_APPROVED => "Your Order $order->num was Approved",
            Constants::ORDER_DELIVERED => "Your Order $order->num Was Delivered Rate Your Order",
            Constants::ORDER_RECEIVED => "Your Order $order->num Was Received",
             Constants::ORDER_PREPARED => "Your Order $order->num is Prepared",
            null => ""
        ];
         return $messages[$order->status];
    }

     public function getIcon($order)
    {
         $icon = [
            Constants::ORDER_NEW => asset('notification_icons/box.svg'),
            Constants::ORDER_APPROVED => "Your Order $order->num was Approved",
            Constants::ORDER_DELIVERED => "Your Order $order->num Was Delivered Rate Your Order",
            Constants::ORDER_RECEIVED => "Your Order $order->num Was Received",
             Constants::ORDER_PREPARED => asset('notification_icons/delivery-man.svg'),
            null => ""
        ];
         return $icon[$order->status];
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
            "title" => $this->getMessage($this),
            "icon"  => $this->getIcon($this),
            "type"  => [
                'order_id' => $this->id, 
            ],
            
        ];
    }
}
