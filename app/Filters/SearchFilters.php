<?php

namespace App\Filters;

use Closure;

class SearchFilters
{
    public function handle($request, Closure $next)
    {
        return $next($request)->where('name', 'like', '%' . request('search') . '%');
    }
}
