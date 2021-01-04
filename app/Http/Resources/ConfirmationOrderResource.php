<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Branch;
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
            'clientName' => $this->client->name,
            'email' => $this->email??"",
            'productPoint' => $this->totalProductPoints()??"",
            'orderPoint' => $this->totalOfferPoints()??"",
            'orderNum' => $this->num??"",

            'ShippingAddress'=>[

                 'id'      => $this->addressOrder->id,
                 'label'   => $this->addressOrder->address_lable ??'',
                 'name'    => $this->addressOrder->name ??'',
                 'address' => $this->addressOrder->address ??'',
                 'phone'   => $this->addressOrder->phone ??'',
                 'time'    => Carbon::parse($this->delivery_date)->format('M d Y H:i A')  ??'' ,
            ],

            'paymentMethod'=>[

                 'payment'      => 'Cash',
            ],

            'orderSummary' =>[

                'totalItems' => $this->getOrder()->count(),
                'priceItems' =>  $this->getOrder()->sum('price'),
                'shippingFee'=> intval($this->shipping_fee) ?? "",
                'totalPrice' =>  $this->total_money??"",
                'totalorderPrice' =>  $this->total_money + $this->shipping_fee + 0 ,
                'estimatedVat'=> 0,
                'paymentMethod'=>'Cash',
            ],

            'products'=>$this->products->map(function($product){
                return[
                    'id' => $product->id,
                    'name' => $product->name,
                    'productImage' => asset('product_images/'.$product->images),
                    //'supermaketId' => $product->branches->first()->id??"",
                    'categoryName' => $product->category->name,
                    'productDesc' => $product->description,
                    'price' =>  DB::table('order_product')->where('order_id',$this->id)->where('product_id', $product->id)->first()->price,
                    'quantity' => DB::table('order_product')->where('order_id',$this->id)->where('product_id', $product->id)->first()->quantity,
                    'branchName' => Branch::Where('id',$this->branch_id)->first()->name??"",
                ];
            }),

        ];
    }


    private function totalProductPoints()
    {
              return  DB::table('order_product')
                      ->where('order_id',$this->id)
                      ->whereIn('product_id', $this->products->pluck('id'))
                      ->sum('points');

              
              //$point = DB::table('products')->whereIn('id',$this->products->pluck('id'))->pluck('points');


    }

    private function totalOfferPoints()
    {
        
       $offer         =  DB::table('offers')->where('type','point')->where('source', 'Delivertto')->first();
       $offerBranches =  DB::table('offers')->where('type','point')->where('source', 'Branch')->get();

           if ($offer) {

            if ($this->total_before >= $offer->total_order_money) {
                                 
                   return strval($offer->value);
                 }else{
                    return '';
                 }
                
               
           }elseif($offerBranches){

                 foreach ($offerBranches as $key => $offerBranch) {
                   
                        if ($offerBranch->branch_id == $this->branch_id) {

                             if ($this->total_before >= $offerBranch->total_order_money) {
                                 
                                return strval($offerBranch->value);
                             }else{
                                return '';
                             }
                        }//end if
                 }//end foreach  



           }else{

             return "";

           }//end if 

    }


    private function getOrder()
    {
        return DB::table('order_product')->where('order_id',$this->id);
    }



}
