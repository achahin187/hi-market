<?php


namespace App\Pipeline;


class MostPopular extends Filter
{
    protected function canRunRequest()
    {

        return request("sortBy") && request("sortBy") == 1;
    }

    protected function query($builder)
    {

        return $builder->where("views", "!=", null)->orderBy("views", "asc");
    }
}
