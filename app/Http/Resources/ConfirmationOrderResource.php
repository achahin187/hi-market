<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
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
            'point' => $this->totalProductPoints-()??"",
            'orderNum' => $this->num??"",

            'ShippingAddress'=>[

                 'id'      => $this->addressOrder->id,
                 'name'    => $this->addressOrder->name ??'',
                 'address' => $this->addressOrder->address ??'',
                 'phone'   => $this->addressOrder->phone ??'',
                 'time'    => Carbon::parse($this->delvery_date)->format('M d Y H:i A')  ??'' ,
            ],
        ];
    }


    private function totalProductPoints()
    {
        
        return DB::table('products')->whereIn('id',$this->products->pluck('id'))->sum('points');
    }
}
