<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Offer;
class HomeDataResource extends JsonResource
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
                "id"=>$this->id,
                "name"=>$this->name,
                "state"=>$this->getState(),
                "flag" =>$this->getState() == 'open' ? 1 : 0,
                "start_time"=>$this->start_time,
                "end_time"=>$this->end_time,
                "rating"=>$this->rating,
                "city_id"=>$this->city_id,
                "city"=> $this->city->name?? '',
                "imagepath"=> asset('branche_image/'.$this->image),
                "logopath"=>asset('branche_image/'.$this->logo),
                'isOffer'=> !!$this->getOffer(),
                'totalMoney'=> $this->getOffer()->total_order_money,
                

            ];
    }

    public function getOffer()
    {
        $offer = Offer::where('type','free delivery')->first();
        return $offer;
    }
    public function getState()
    {


         // $start_times = Carbon::parse($this->start_time)->format("H:i A");
         // $end_times = Carbon::parse($this->end_time)->format("H:i A");


        $now = Carbon::now();
        $start_time = Carbon::createFromTimeString($this->start_time);
        $end_time = Carbon::createFromTimeString($this->end_time)->addDay();

       

    
        if ($now->between($start_time, $end_time, true) ) {

            return 'open';

        } else {
            return 'closed';

        }


    }

}
