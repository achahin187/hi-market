<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            "id"=>$this->id,
            "name"=>$this->name,
            "email"=>$this->email,
            "phone"=>$this->mobile_number,
            "total_points"=>!is_null($this->total_points) ? $this->total_points : 0,
            "image"=>!is_null($this->image) ? asset('client/'$this->image) : "default.png",

        ];
    }
}
