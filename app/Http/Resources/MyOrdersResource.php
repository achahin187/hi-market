<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class MyOrdersResource extends JsonResource
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
            'orderNumer' => $this->num,
            'created_at' => Carbon::parse($this->created_at)->format('M d Y'),
            'status' => $this->getStatus(),
            'products'=>$this->products->map(function($product){
                return[
                'id' => $product->id,
                'name' => $product->name,
                'image' => asset('images/'.$product->image),
                'supermaketId' => $product->branches->first()->id,
                ];
            }),

        ];
    }

    private function getStatus()
    {
        $statuses = 
                [
                    'Pending'      => 0,
                    'Accepted'     => 1,
                    'Process'      => 2,
                    'Pickup'       => 3,
                    'Deliverd'     => 4,
                ];

        foreach ($statuses as $index => $status) {
            if ($this->status == $status) {
                return $index;
            }

        } 

    } //end function 

 



}
