<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
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
                "start_time"=>$this->start_time,
                "end_time"=>$this->end_time,
                "rating"=>$this->rating,
                "city_id"=>$this->city_id,
                "city"=> $this->city->name,
                "imagepath"=>asset($this->imagepath),
                "logopath"=>asset($this->logopath),
             
            ];
    }

    public function getState()
    {
       
        if (Carbon::now()->parse(format('g:i A'))->between($this->start_time, $this->end_time) ) {

            return 'open';

        }else{
            return 'closed';

        }

         
    }
  
}
