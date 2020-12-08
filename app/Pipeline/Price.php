<?php


namespace App\Pipeline;


class Price extends Filter
{
    protected function canSkipRequest()
    {
        return request($this->filterRequest()) && request($this->filterRequest()) == false;
    }

    protected function query($builder)
    {
        return $builder->orderBy("price",request("order","asc"));
    }
}
