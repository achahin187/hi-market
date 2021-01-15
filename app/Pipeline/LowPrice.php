<?php


namespace App\Pipeline;


class LowPrice extends Filter
{
    protected function canRunRequest()
    {
        return request( "sortBy") && request("sortBy") == 3;
    }

    protected function query($builder)
    {

        return $builder->orderBy("price","asc");
    }
}
