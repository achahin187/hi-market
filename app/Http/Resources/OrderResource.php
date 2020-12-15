<?php

namespace App\Http\Resources;

use App\Constants;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function getMessage($order)
    {
         $messages = [
            Constants::ORDER_NEW => "New Order Created",
            Constants::ORDER_APPROVED => "You Approved New Order",
            Constants::ORDER_DELIVERED => "Your Order $order->num Was Delivered Rate Your Order",
            Constants::ORDER_RECEIVED => "You Received New Order",
            null => ""
        ];
         return $messages[$order->status];
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,

            "message" => $this->getMessage($this),
            "status" => $this->status,
        ];
    }
}
