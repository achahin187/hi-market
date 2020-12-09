<?php


namespace App\Pipeline;


class Vendor extends Filter
{
    protected function canRunRequest()
    {
        return request("vendor");
    }

    protected function query($builder)
    {
        return $builder->whereHas("vendors", function ($query)
        {
            $query->where("vendors.id",explode(",",request("vendor")));
        });
    }
}
