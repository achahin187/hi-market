<?php


namespace App\Pipeline;


class LastSixtyDays extends Filter
{
    protected function canRunRequest()
    {
        return request("new_arrival") && request("new_arrival") == 2;
    }

    protected function query($builder)
    {
        return $builder->whereDate("products.created_at", ">", date("Y-m-d H:i:s", now()->subDays(60)->timestamp));
    }
}
