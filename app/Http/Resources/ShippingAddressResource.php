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
            'id' => $this->address,
            'name' => $this->address->name ??'',
            'address' => $this->address->address ??'',
            'phone' => $this->address->phone ??'',
            'time' => $this->delivery_date ??'',
        ];
    }
}
