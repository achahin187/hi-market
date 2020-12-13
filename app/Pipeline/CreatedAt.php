<?php


namespace App\Pipeline;


class CreatedAt extends Filter
{
    protected function query($builder)
    {

        return $builder->whereDate("created_at",date("Y-m-d",strtotime(request($this->filterRequest()))));
    }
}
