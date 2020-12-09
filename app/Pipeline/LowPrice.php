<?php


namespace App\Pipeline;


class LowPrice extends Filter
{
    protected function canSkipRequest()
    {
        return request(  "sortBy") && request("sortBy") == 3;
    }

    protected function query($builder)
    {

        return $builder->orderBy("price","asc");
    }
}
