<?php

namespace App\Http\Resources;

use App\Models\Branch;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
{
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
            "name" => $this->name,
            "price" => $this->price ?? 0,
            "offer_price" => $this->offer_price ?? 0,
            "percentage" => ($this->offer_price / $this->price) * 100,
            "imagepath" => asset($this->image),
            "category_id" => $this->category->id,

            "categoryname" => $this->category->name,

            "supermarket_id" => Branch::find(request("supermarket_id"))->id,

            "supermarketname" => Branch::find(request("supermarket_id"))->name,


            "description" => $this->description ?? ""

        ];
    }
}
