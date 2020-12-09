<?php

namespace App\Http\Resources;

use App\Models\Branch;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product= $this->product;

        return [
            "id"=>$product->id,
            "name"=>$product->name,

            "description" => $product->description,
            "overview" => $product->specs ?? "",
            "price" => $product->price ?? 0,
            "offer_price" => $product->offer_price ?? 0,
            "rate" => $product->rate ?? 0,
            "ratings" => $product->ratings ?? "0",
            "priority" => $product->priority ?? 0,
            "images" => asset("images/" . $this->images),
            "points" => $product->points ?? 0,
            "category_name" => $product->category->name ?? "",
            "category_id" => $product->category_id ?? "",
            "flag" => $product->flag ?? 0,
            "supermarket_id" => (int)request("supermarket_id"),
            "supermarketName" => $this->getBranch()->name,
            "favourite" => $product->favourite ?? 0,
            "percentage" =>  $product->offer_price ? (int)(100-(($this->offer_price/$this->price)*100)) : 0,
            "imagepath" => $product->imagepath ?? "default.png",
            "category" => $product->category ?? "",
            "quantity"=>$this->qty,


        ];
    }
    private function getBranch()
    {
        return Branch::Where('id',request("supermarket_id"))->first();
    }
}
