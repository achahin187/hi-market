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
      Carbon::setlocale(request()->header('lang'));
        return [
                "id"=>$this->id,
                "name"=>$this->name,
                "state"=>$this->getState(),
                "flag" =>$this->getState() == 'open' ? 1 : 0,
                "start_time"=>Carbon::parse($this->start_time)->translatedFormat("g:i a"),
                "end_time"=>Carbon::parse($this->end_time)->translatedFormat("g:i a"),
                "rating"=>$this->rating,
                "city_id"=>$this->city_id,
                "city"=> $this->city->name?? '',
                "imagepath"=> asset('branche_image/'.$this->image),
                "logopath"=>asset('branche_image/'.$this->logo),
                'isOffer'=> !!$this->getOffer(),
                'totalMoney'=> (string)$this->getOffer()->total_order_money??"0",
                

            ];
    }

    public function getOffer()
    {
        $offer = Offer::where('type','free delivery')->first();
        return $offer;
    }

    public function getState()
    {
       $now = now();
       
       $start_time =  Carbon::parse($this->start_time)->format('H:i');
       $end_time   =  Carbon::parse($this->end_time)->format('H:i');
      

      if ($start_time == $end_time) {
       
          return 'open';
      }

      elseif($start_time < $end_time)
      {
              
        $between = $now->between($start_time, $end_time);

            if ($between) {
               
                return 'open';
            }else{
               
                return 'closed';
            }//end if
      }else{
            if (Carbon::now()->toTimeString() > $start_time) {
               
                return 'open';
            }
            elseif(Carbon::now()->toTimeString() < $end_time){
               
                return 'open';
            }else{
                
                return 'closed';

            }//end if
      }//end if

    }//end function 
         


}
