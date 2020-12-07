<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return
            [
                "id" => $this->id,
                "name" => $this->name,
                "description" => $this->description,
                "overview" => $this->specs ?? "",
                "price" => $this->price ?? 0,
                "offer_price" => $this->offer_price ?? 0,
                "rate" => $this->rate ?? 0,
                "ratings" => $this->ratings ?? 0,
                "priority" => $this->priority ?? 0,
                "images" => asset("images/" . $this->images),
                "points" => $this->points ?? 0,
                "category_name" => $this->category->name ?? "",
                "category_id" => $this->category_id ?? "",
                "flag" => $this->flag ?? 0,
                "supermarket_id" =>request("supermarket_id"),
                "favourite" => $this->favourite ?? 0,
                "percentage" =>  $this->offer_price ? (int)(100-(($this->offer_price/$this->price)*100)) : 0,
                "imagepaths" => $this->imagepaths ?? "default.png",
                "category" => $this->category ?? "",
                
            ];
    }
}
