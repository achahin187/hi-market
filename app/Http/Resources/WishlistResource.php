<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
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
            "product_name"=>$this->name,
            "price"=>$this->price??0,
            "offer_price"=>$this->price_offer,
            "percentage"=>($this->offer_price / $this->price) * 100,
            "imagepath"=>asset($this->image),
            "categoryname"=>$this->category->name,
            "supermarketname"=>$this->supermarket->name,
            "description" =>$this->description

        ];
    }
}
