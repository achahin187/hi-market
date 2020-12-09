<?php


namespace App\Pipeline;


class Vendor extends Filter
{
    protected function canRunRequest()
    {
        return request( "vendor") ;
    }

    protected function query($builder)
    {
        return $builder->whereIn("vendor_id",explode( ",",request("vendor")));
    }
}
