<?php

namespace App\Filters;

use Closure;

class SearchFilters
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)->where('name', 'like', '%' . request('search') . '%');
    }
}
