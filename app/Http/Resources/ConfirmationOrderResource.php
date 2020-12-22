<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use DB;
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

            'ShippingAddress'=>[

                 'id'      => $this->addressOrder->id,
                 'name'    => $this->addressOrder->name ??'',
                 'address' => $this->addressOrder->address ??'',
                 'phone'   => $this->addressOrder->phone ??'',
                 'time'    => Carbon::parse($this->delvery_date)->format('M d Y H:i A')  ??'' ,
            ],

            'paymentMethod'=>[

                 'payment'      => 'Cash',
            ],

            'orderSummary' =>[
                'totalItems' => $this->getOrder()->count(),
                'priceItems' =>  $this->getOrder()->sum('price'),
                'shippingFee'=> 5,
                'totalPrice' =>  $this->getOrder()->sum('price') + 5 + 10,
                'estimatedVat'=> 10,
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


    private function totalProductPoints()
    {
        
        return DB::table('products')->whereIn('id',$this->products->pluck('id'))->sum('points');
    }

    private function getOrder()
    {
        return DB::table('order_product')->where('order_id',$this->id);
    }
}
