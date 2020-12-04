<?php


namespace App\Traits;




use App\Pipeline\SortBy\SortBy;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;

trait HasFilter
{

    public function scopeFilter($query)
    {

        return app(Pipeline::class)
            ->send($query)
            ->through(array_merge($this->queryFilters,[SortBy::class]))
            ->thenReturn();

    }

    protected function getFiltersAttribute()
    {
        $queryFilters = [];
        foreach ($this->queryFilters as $filter) {
            $queryFilters[] = Str::snake(class_basename($filter));
        }
        return $queryFilters;
    }
}
