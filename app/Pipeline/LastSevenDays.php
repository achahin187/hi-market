<?php


namespace App\Pipeline;


class LastSevenDays extends Filter
{
    protected function canSkipRequest()
    {
        return request(  "new_arrival") && request("") == 4;
    }

    protected function query($builder)
    {

        return $builder->orderBy("created_at", "desc");
    }
}
