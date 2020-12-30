<?php


namespace App\Pipeline;


class CategoryId extends Filter
{
	protected function canRunRequest()
	{
		return request("category_id");
	}

    protected function query($builder)
    {
        return $builder->whereHas("category", function ($query) {
            $query->where("id",request("category_id"));
        });
    }
}
