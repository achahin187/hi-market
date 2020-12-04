<?php


namespace App\Pipeline;


class MostPopular extends Filter
{
    protected function canSkipRequest()
    {

        return request($this->filterRequest()) && request("most_popular") == false;
    }

    protected function query($builder)
    {

        return $builder->where("views", "!=", null)->orderBy("views", "asc");
    }
}
