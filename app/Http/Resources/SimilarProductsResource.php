<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            "imagepaths" => $this->imagepaths ? explode(",", $this->images) : [],

            "images"=>$this->images != ""  ?$this->images:  "default.png",
            "supermarket_id" => (int)request("supermarket_id")

        ];
    }
}
