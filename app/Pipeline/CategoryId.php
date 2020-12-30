<?php


namespace App\Pipeline;


class CategoryId extends Filter
{
	protected function canRunRequest()
	{
		return request($this->filterRequest());
	}

    protected function query($builder)
    {
        return $builder->whereHas("category", function ($query) {
            $query->where("id",request($this-filterRequest()));
        });
    }
}
