<?php

namespace App\Http\Resources;

use App\Models\Branch;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $product = $this->product;

        return [
            "id" => $product->id,
            "name" => $product->name,
            "description" => $product->description,
            "overview" => $product->specs ?? "",
            "price" => $product->price ?? 0,
            "offer_price" => $product->offer_price ?? 0,
            "rate" => $product->rate ?? 0,
            "ratings" => (string)$product->ratings ?? "0",
            "priority" => $product->priority ?? 0,
            "images" => asset("product_images/" . $product->images)??"",
            "points" => $product->points ?? 0,
            "category_name" => $product->category->name ?? "",
            "category_id" => $product->category_id ?? "",
            "flag" => $product->flag ?? 0,
            "supermarket_id" => (int)request("supermarket_id"),
            "supermarketName" => $this->getBranchName(),
            "favourite" => $product->favourite ? 1 : 0,
            "percentage" => $product->price && $this->offer_price ? (100 - (($this->offer_price / $this->price) * 100)) : 0,
            "imagepath" => asset("product_images/" . $product->images)??"",
            "category" => $product->category ?? "",
            "quantity" => (int)$this->qty,


        ];
    }

    private function getBranchName()
    {
        return Branch::Where('id', request("supermarket_id") )->value("name_".app()->getLocale());
    }
}
