<?php

namespace App\Models;

use App\Traits\SearchableTrait;

class Permission extends \Spatie\Permission\Models\Permission
{
    use SearchableTrait;

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'roles.name' => 10,
            'roles.display_name' => 10,
        ],
        'joins' => [],
    ];
}
