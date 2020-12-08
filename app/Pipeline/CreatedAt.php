<?php


namespace App\Pipeline;


class CreatedAt extends Filter
{
    protected function canSkipRequest()
    {
        return request($this->filterRequest()) && request($this->filterRequest()) == false;
    }

    protected function query($builder)
    {

        return $builder->orderBy("created_at",request("order","asc"));
    }
}
