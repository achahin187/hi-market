<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;
use App\Models\Branch;
class SearchResource extends JsonResource
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
             "id" => $this->getProduct()->id,

            "name" => $this->getProduct()->name,
            "description" => $this->getProduct()->description,
            //"overview" => $this->getProduct()->specs ?? "",
            "price" => $this->getProduct()->price ?? 0,
            //"offer_price" => $this->getProduct()->offer_price ?? 0,
            "rate" => $this->getProduct()->rate ?? 0,
            //"ratings" => $this->getProduct()->ratings ?? "0",
            //"priority" => $this->getProduct()->priority ?? 0,
            "images" => asset("images/" . $this->getProduct()->images),
            "points" => $this->getProduct()->points ?? 0,
            "category" => $this->getProduct()->category->name ?? "",
            //"category_id" => $this->getProduct()->category_id ?? "",
            //"flag" => $this->getProduct()->flag ?? 0,
            "supermarketId" => $this->getBranch()->id,
            //"supermarketName" =>$this->getBranch()->name,
            //"favourite" => (int)(\DB::table("client_product")->where("product_id",$this->getProduct()->id)->where("udid",request()->header("udid"))->count() != 0),
            //"percentage" => $this->getProduct()->price && $this->getProduct()->offer_price ? (100 - (($this->getProduct()->offer_price / $this->getProduct()->price) * 100)) : 0,
            //"imagepath" => $this->getProduct()->imagepath ?? "default.png",
            //"category" => $this->getProduct()->category ?? "",
            //"quantity" => (int)$this->getProduct()->qty,
            'vendor' => $this->getProduct()->name ?? "",
        ];
    }

//'id' => $product->id,
                //                 'name' => $product->name_ar,
                //                 'description' => $product->arab_description,
                //                 'rate' => $product->rate,
                //                 'supermarketId'=> $product->branch_id,
                //                 'price' => $product->price,
                //                 'offer_price' => $product->offer_price,
                //                 'images' => asset('product_images/'.$product->images),
                //                 'points' => $product->points,
                //                 'category' => !is_null($product->category) ? $product->category->name_ar : "",
                //                 'vendor' => !is_null($product->vendor) ? $product->vendor->arab_name : ""
                //             ];
           

    private function getProduct()
    {
        return Product::where('id', $this->product_id)->first();
    }

    private function getBranch()
    {
        return Branch::where('id', $this->branch_id)->first();
    }
}
