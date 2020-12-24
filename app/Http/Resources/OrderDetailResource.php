<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use DB;
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
                'name' => $this->addressOrder->name,
                'desc' => $this->addressOrder->address,
                'phone' => $this->addressOrder->phone,
            ],

            'orderSummary' =>[
                'totalItems' => $this->getOrder()->count(),
                'priceItems' =>  $this->getOrder()->sum('price'),
                'shippingFee'=> 5,
                'totalPrice' =>  $this->getOrder()->sum('price') + 5 + 10,
                'estimatedVat'=> 10,
                'paymentMethod'=>'Cash',
            ],


            'products'=>$this->products->map(function($product){
                return[
                'id' => $product->id,
                'name' => $product->name,
                'productImage' => asset('images/'.$product->image),
                'supermaketId' => $product->branches->first()->id??"",
                'categoryName' => $product->category->name,
                'productDesc' => $product->description,
                'price' =>  DB::table('order_product')->where('order_id',$this->id)->where('product_id', $product->id)->first()->price,
                'quantity' => DB::table('order_product')->where('order_id',$this->id)->where('product_id', $product->id)->first()->quantity,
                'branchName' => $product->branches->first()->name??"",
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

    private function getOrder()
    {
        return DB::table('order_product')->where('order_id',$this->id);
    }

   
}
