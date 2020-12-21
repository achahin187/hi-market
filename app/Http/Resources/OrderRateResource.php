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
            'delivery_rate' => $request->delivery_rate,
            'seller_rate' => $request->seller_rate,
            'pickup_rate' => $request->pickup_rate,
            'time_rate' => $request->time_rate,
            'comment' => $request->comment,
        ];
    }
}
