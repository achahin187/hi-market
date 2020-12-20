<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class OrderDetailResource extends JsonResource
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
            'status' => $this->getStatus(),
            'date' => Carbon::parse($this->delvery_date)->format('M d Y'),
            'address'=>$this->client->map(function($client){
                return[
                'name' => $client->name,
                'desc' => $client->addresses->first()->name,
                'phone' => $client->addresses->first()->phone,
                ];
            }),
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
                    'Canceled'     => 5,
                ];

        foreach ($statuses as $index => $status) {
            if ($this->status == $status) {
                return $index;
            }

        } 

    } //end function 
}
