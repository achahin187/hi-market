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
            'orderNumber' => $this->num,
            'status' => $this->getStatus(),
            'time' => Carbon::parse($this->delivery_date)->format('M d Y H:i A')?? '',
            'placedOn' => Carbon::parse($this->created_at)->format('M d Y')?? '',
            'deliverdOn' => Carbon::parse($this->delivery_date)->format('M d Y')??'',
            'rate' => $this->checkRate(),

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
                    'productImage' =>  asset("product_images/" . $product->images),

                    'supermaketId' => $this->branch_id??"",
                    'supermaketName' => $product->branches->where('id',$this->branch_id)->first()->name??"",

                    'categoryId' => $product->category->id,
                    'categoryName' => $product->category->name,
                    'productDesc' => $product->description,

                    'price' =>  DB::table('order_product')->where('order_id',$this->id)->where('product_id', $product->id)->first()->price,

                    'favourite' => (int) (\DB::table("client_product")->where("product_id",$this->id)->where("udid",request()->header("udid"))->count() != 0),

                    'quantity' => DB::table('order_product')->where('order_id',$this->id)->where('product_id', $product->id)->first()->quantity,

                    'branchName' => $product->branches->where('id',$this->branch_id)->first()->name??"",
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
                    'Received'     => 5,
                    'Canceled'     => 6,
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

    private function checkRate()
    {   
        $rates = [$this->delivery_rate, $this->seller_rate, $this->pickup_rate, $this->time_rate];
        foreach ($rates as  $rate) {
        
            if ($rate != null) {
               return true;
            }else{

               return false;
            }
        }
       
    }


   
}
