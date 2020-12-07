<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,

            "address"=>$this->address,
            "rate"=>$this->rate ?? 0,
            "delivery_date"=>$this->delivery_date ?? "",
            "delivery_rate"=>$this->delivery_rate ?? "",
            "client_review"=>$this->client_review?? "",
            "review_status"=>$this->review_status?? "",
            "order_price"=>$this->order_price?? "",
            "status"=>$this->status,

        ];
    }
}
