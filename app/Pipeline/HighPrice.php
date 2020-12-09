<?php


namespace App\Pipeline;


class HighPrice extends Filter
{
    protected function canSkipRequest()
    {

        return request("sortBy") && request("sortBy") == 2;
    }

    protected function query($builder)
    {
        return $builder->orderBy("price","desc");
    }
}
