<?php

namespace App\Filters;

use Closure;
use Illuminate\Http\Request;

class SortFilters
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, $next): mixed
    {
        $query = $next($request);

        if (in_array(request('sortCoulmn', 'id'), ['id', 'name', 'email', 'created_at'])) {

            $query = $query->orderBy(request('sortCoulmn', 'id'), request('sortDirection', 'desc'));
        } else {
            $query = $query->latest();
        }

        return $query;
    }
}
