<?php


namespace App\Pipeline;


class CategoryId extends Filter
{
    protected function query($builder)
    {
        return $builder->whereHas("category", function ($query) {
            $query->whereIn("id",explode(",", request($this->filterRequest())));
        });
    }
}
