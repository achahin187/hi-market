<?php

namespace App\Http\Resources;

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
            "quantity"=>$this->qty,


        ];
    }
}
