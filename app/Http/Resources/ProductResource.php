<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "description"=>$this->description,
            "overview" => $this->specs,
            "price"=>$this->price,
            "offer_price"=>$this->offer_price,
            "rate"=>$this->rate,
            "rating"=>$this->rating,
            "priority"=>$this->priority,
            "images"=>asset("images/".$this->images),
            "points"=>$this->points,
            "category_name"=>$this->category->name,
            "category_id"=>$this->category_id,
            "flag"=>$this->flag,
            "supermarket_id"=>$this->supermarkt_id,
            "favourite"=>$this->favourite,
            "percentage"=>$this->percentage,
            "imagepath"=>$this->imagepath,
            "category"=>$this->category

        ];
    }
}
