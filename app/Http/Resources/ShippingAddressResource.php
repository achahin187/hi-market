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
            'id' => $this->order,
            'name' => $this->order,
            'address' => $this->order,
            'phone' => $this->order,
            'time' => $this->order->delivery_date,
        ];
    }
}
