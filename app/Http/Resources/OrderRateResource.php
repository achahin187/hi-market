<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderRateResource extends JsonResource
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
            'delivery_rate' => $this->delivery_rate,
            'seller_rate' => $this->seller_rate,
            'pickup_rate' => $this->pickup_rate,
            'time_rate' => $this->time_rate,
            'comment' => $this->comment,
        ];
    }
}
