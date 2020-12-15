<?php

namespace App\Http\Resources;

use App\Constants;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    private $messages = [
        Constants::ORDER_NEW => "New Order Created",
        Constants::ORDER_APPROVED => "You Approved New Order",
        Constants::ORDER_DELIVERED => "Your Order Was Delivered Rate Your Order",
        Constants::ORDER_RECEIVED => "You Received New Order",
        null => ""
    ];

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

            "message" => $this->messages[$this->status],
            "status" => $this->status,
        ];
    }
}
