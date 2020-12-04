<?php


namespace App\Pipeline;


use Illuminate\Support\Str;

class Filter
{
    public function handle($request, \Closure $next)
    {
        if (!request()->has($this->filterRequest()) || request($this->filterRequest()) == null) {
            return $next($request);
        }
        return $this->query($next($request));

    }

    protected function filterRequest()
    {
        return Str::snake(class_basename($this));
    }

    protected function query($builder)
    {

        return $builder->where($this->filterRequest(),"LIKE", "%" . request($this->filterRequest()) . "%");
    }

}
