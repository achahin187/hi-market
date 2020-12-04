<?php


namespace App\Pipeline;


class Price extends Filter
{
    protected function query($builder)
    {
        return $builder->orderBy("price", request($this->filterRequest()));
    }
}
