<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\Offer;
use DateTime;
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
                "start_time"=>Carbon::parse($this->start_time)->format("g:i a"),
                "end_time"=>Carbon::parse($this->end_time)->format("g:i a"),
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

       $time = $this->isBetween($this->start_time, $this->end_time, now());

       if($time == true){
        return 'open';
       }else{

        return 'closed';
       }

    }
         
    public function isBetween($from, $till, $input) {
        $fromTime = strtotime($from);
        $toTime = strtotime($till);
        $inputTime = strtotime($input);

        return $inputTime >= $fromTime and $inputTime <= $toTime;
    }

}
