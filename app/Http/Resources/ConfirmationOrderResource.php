<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfirmationOrderResource extends JsonResource
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
            'id' => $this->id,
            'email' => $this->email??"",
            'point' => $this->totalProductPoints()??"",
            'orderNum' => $this->num??"",
        ];
    }


    private function totalProductPoints()
    {
        $this->products()->sum('point');
    }
}
