<?php


namespace App\Pipeline;


class LastThirtyDays extends Filter
{
    protected function canRunRequest()
    {
        return request("new_arrival") && request("new_arrival") == 3;
    }

    protected function query($builder)
    {
        return $builder->whereDate("products.created_at", ">", date("Y-m-d H:i:s", now()->subDays(30)->timestamp));
    }
}
