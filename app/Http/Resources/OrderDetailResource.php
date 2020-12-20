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

            'address'=>[
                'name' => $this->client->name,
                'desc' => $this->client->addresses->first()->description,
                'phone' => $this->client->addresses->first()->phone,
            ],


            'products'=>$this->products->map(function($product){
                return[
                'id' => $product->id,
                'name' => $product->name,
                'productImage' => asset('images/'.$product->image),
                'supermaketId' => $product->branches->first()->id,
                'categoryName' => $product->category->name,
                'productDesc' => $product->description,
                'price' => $product->price,
                'quantity' => $this->getQty()->quantity,
                'branchName' => $product->branches->first()->name,
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

    private function getQty()
    {
       return  DB::table('order_client')->where('order',$this->id)->where('product_id', $product->id)->first();
    }
}
