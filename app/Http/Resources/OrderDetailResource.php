<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'products' => $this->products->map(function($product){

                return [
                    'id'=>$product->id,
                    'supermaketId' => $product->branches->first()->id,
                    'productImage' => asset('product_images/'.$product->image),
                    'productDesc' => $product->description,
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
