<?php


namespace App\Pipeline\SortBy;


use App\Pipeline\Filter;

class SortBy extends Filter
{
    public function handle($request, \Closure $next)
    {

        if (!request("sortBy") && request("sortBy") == null) {
            return $next($request);
        }
        $builder = $next($request);
        return $this->query($builder);
    }

    protected function query($builder)
    {
        return $builder->orderBy(request("sortBy"), request("order","asc"));
    }
}
