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
                "flag" =>$this->getState() == 'open' ? 1 : 0,
                "start_time"=>$this->start_time,
                "end_time"=>$this->end_time,
                "rating"=>$this->rating,
                "city_id"=>$this->city_id,
                "city"=> $this->city->name,
                "imagepath"=>$this->imagepath,
                "logopath"=>asset($this->logopath),

            ];
    }

    public function getState()
    {

        $now = now();
        $start_time = Carbon::parse($this->start_time)->format("H:i:s");
        $end_time = Carbon::parse($this->end_time)->format("H:i:s");
        if ($now >= $start_time && $now <= $end_time) {

            return 'open';

        } else {
            return 'closed';

        }




    }

}
