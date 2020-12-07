<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "name"=>$this->name,
            "phone"=>$this->phone,
            "govern"=>$this->govern,
            "description"=>$this->description,
<<<<<<< HEAD
            "default"=>!! $this->default,
            "address_label"=>$this->address_label,
=======
            "default"=>$this->default,
            "address_label"=>$this->address_lable,
>>>>>>> cac02b95f6461ad515d54275ef168e66122ab70e
            "lat"=>$this->lat,
            "lon"=>$this->lon,
            "additional"=>$this->additional ?? "",
            "client_id"=>$this->client_id,

        ];
    }
}
