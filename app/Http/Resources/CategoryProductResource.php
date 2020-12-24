<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Branch;

class CategoryProductResource extends JsonResource
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
            "description" => $this->description ?? "",
            "overview" => $this->specs ?? "",
            "price" => $this->price ?? 0,
            "offer_price" => $this->offer_price ?? 0,
            "rate" => $this->rate ?? 0,
            "ratings" => $this->ratings ?? "0",
            "priority" => $this->priority ?? 0,
            "images" => $this->images ? asset("product_images/" . $this->images) : asset("images/default.svg") ,
            "points" => $this->points ?? 0,
            "category_name" => $this->category->name ?? "",
            "category_id" => $this->category_id ?? "",
            "flag" => $this->flag ?? 0,
            "supermarket_id" => (int)request("supermarket_id"),
            "supermarketName" => $this->getBranch(),
            "favourite" =>(int) (\DB::table("client_product")->where("product_id",$this->id)->where("udid",request()->header("udid"))->count() != 0),
            "percentage" => $this->offer_price ? (int)(100 - (($this->offer_price / $this->price) * 100)) : 0,
            "imagepath" => $this->image ?? "default.png",
            "category" => $this->category ?? "",
        ];
    }


    private function getBranch()
    {
        return Branch::Where('id', request("supermarket_id"))->first()->name ?? "";
    }
}
