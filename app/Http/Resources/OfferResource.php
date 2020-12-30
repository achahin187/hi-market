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
            "imagepath" => asset("offer_images/" . $this->banner),
            "imagePopUp" => asset("offer_images/" . $this->banner2),
        ];
    }
}
