<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'promocode' => $this->promocode,
            'offer_type' => $this->offer_type,
            'value_type' => $this->value_type,
            'image' => $this->image,
            "imagepath" => asset("images/" . $this->images),
        ];
    }
}
