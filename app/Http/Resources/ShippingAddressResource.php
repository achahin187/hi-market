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
            'id'      => $this->addressOrder->id,
            'name'    => $this->addressOrder->name ??'',
            'address' => $this->addressOrder->address ??'',
            'phone'   => $this->addressOrder->phone ??'',
            'time'    => $this->delivery_date ??'' ,
        ];
    }
}
