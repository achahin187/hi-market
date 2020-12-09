<?php


namespace App\Pipeline;


class LastSevenDays extends Filter
{
    protected function canSkipRequest()
    {
        return request(  "new_arrival") && request("new_arrival") == 4;
    }

    protected function query($builder)
    {

        return $builder->whereDate("created_at",">",date("Y-m-d H:i:s",now()->subDays(7)->timestamp));
    }
}
