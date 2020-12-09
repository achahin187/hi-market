<?php


namespace App\Pipeline;


class CreatedAt extends Filter
{
    protected function canSkipRequest()
    {
        return request(  "sortBy") && request("sortBy") == 4;
    }

    protected function query($builder)
    {

        return $builder->orderBy("created_at", "desc");
    }
}
