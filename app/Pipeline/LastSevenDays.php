<?php


namespace App\Pipeline;


class LastSevenDays extends Filter
{
    protected function canRunRequest()
    {
        return request(  "new_arrival") && request("new_arrival") == 1;
    }

    protected function query($builder)
    {

        return $builder->whereDate("created_at",">",date("Y-m-d H:i:s",now()->subDays(7)->timestamp));
    }
}
