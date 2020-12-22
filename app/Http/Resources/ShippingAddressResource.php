<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingAddressResource extends JsonResource
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
            'id' => $this->order->address->id,
            'name' => $this->order->address,
            'address' => $this->order->address,
            'phone' => $this->order->address,
            'time' => $this->order->delivery_date,
        ];
    }
}
