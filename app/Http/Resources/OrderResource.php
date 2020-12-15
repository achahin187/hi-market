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
            "id" => $this->id,

            "message" => $this->getMessage($this),
            "status" => $this->status,
        ];
    }
}
