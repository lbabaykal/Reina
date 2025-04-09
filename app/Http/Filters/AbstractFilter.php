<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class AbstractFilter implements FilterInterface
{
    public function handle(array $data, \Closure $next)
    {
        /** @var Builder $builder */
        $builder = $data['query'];
        /** @var array $validatedData */
        $validatedData = $data['validatedData'];

        if (array_key_exists($this->getName(), $validatedData)) {
            $this->applyFilter($builder, $validatedData);
        }

        return $next($data);
    }

    protected function getName(): string
    {
        return Str::snake(Str::before(class_basename($this), 'Filter'));
    }
}
