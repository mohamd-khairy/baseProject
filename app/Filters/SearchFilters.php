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
        $query = $next($request);

        if (request('search')) {
            $query->search(request('search'));
        }

        return $query;
    }
}
