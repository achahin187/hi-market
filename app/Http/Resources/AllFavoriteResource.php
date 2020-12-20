<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;
use App\Models\Branch;
class AllFavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
       //$idOfPosts = $this->branches->pluck('id');
       
        return [

            
            "id" => $this->getProduct()->id,

            "name" => $this->getProduct()->name,
            "description" => $this->getProduct()->description,
            "overview" => $this->getProduct()->specs ?? "",
            "price" => $this->getProduct()->price ?? 0,
            "offer_price" => $this->getProduct()->offer_price ?? 0,
            "rate" => $this->getProduct()->rate ?? 0,
            "ratings" => $this->getProduct()->ratings ?? "0",
            "priority" => $this->getProduct()->priority ?? 0,
            "images" => asset("images/" . $this->getProduct()->images),
            "points" => $this->getProduct()->points ?? 0,
            "category_name" => $this->getProduct()->category->name ?? "",
            "category_id" => $this->getProduct()->category_id ?? "",
            "flag" => $this->getProduct()->flag ?? 0,
            "supermarket" => $this->getBranch()->id,
            "supermarketName" =>$this->getBranch()->name,
            "favourite" => (int)(\DB::table("client_product")->where("product_id",$this->getProduct()->id)->where("udid",request()->header("udid"))->count() != 0),
            "percentage" => $this->getProduct()->price && $this->getProduct()->offer_price ? (100 - (($this->getProduct()->offer_price / $this->getProduct()->price) * 100)) : 0,
            "imagepath" => $this->getProduct()->imagepath ?? "default.png",
            "category" => $this->getProduct()->category ?? "",
            "quantity" => (int)$this->getProduct()->qty
        ];
    }


    private function getProduct()
    {
        return Product::where('id', $this->product_id)->first();
    }

    private function getBranch()
    {
        return Branch::where('id', $this->supermarket_id)->first();
    }



    
}
