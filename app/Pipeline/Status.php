<?php


namespace App\Pipeline;


class Status extends Filter
{
    protected function query($builder)
    {
        return $builder->where($this->filterRequest(), request($this->filterRequest()));
    }
}
