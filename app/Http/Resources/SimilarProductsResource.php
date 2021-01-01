<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Branch;
class SimilarProductsResource extends JsonResource
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
            "price" => $this->price,
            "offer_price" => $this->offer_price ?? 0,
            "description" => $this->description,
            "favourite" => $this->favourite ?1: 0,
            "rate" => $this->rate ?? 0,
            "ratings" => $this->ratings ?? 0,
            "overview" => $this->specs ?? "",
            "points" => $this->points ?? 0,
            "priority" => $this->priority ?? 0,
            "category_name" => $this->category->name ?? "",
            "category_id" => $this->category_id ?? "",
            "flag" => $this->flag ?? 0,
            "imagepaths" => $this->imagepaths ? explode(",", $this->images) : [],
            "images"=>asset("product_images/" . $this->images),
            "supermarket_id" =>  (int) request("supermarket_id"),
            "supermarketName" => $this->getBranch()->name,
            "percentage" => $this->offer_price ? (int)(100-(($this->offer_price/$this->price)*100)) : 0,


        ];
    }

    private function getBranch()
    {
        return Branch::Where('id', request("supermarket_id"))->first();
    }
}
