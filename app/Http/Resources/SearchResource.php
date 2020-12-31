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
            "price" => $this->getProduct()->price ?? 0,
            "offer_price" => $this->getProduct()->offer_price ?? 0,
            "rate" => $this->getProduct()->rate ?? 0,
            "images" => asset("product_images/" . $this->getProduct()->images),
            "points" => $this->getProduct()->points ?? 0,
            "category" => $this->getProduct()->category->name ?? "",
            "supermarketId" => $this->getBranch()->id,
            'vendor' => $this->getProduct()->name ?? "",
        ];
    }


    private function getProduct()
    {
        return Product::where('id', $this->product_id)->first();
    }

    private function getBranch()
    {
        return Branch::where('id', $this->branch_id)->first();
    }
}
