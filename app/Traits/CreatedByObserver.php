<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait CreatedByObserver
{
    /**
     * @return void
     */
    public static function bootCreatedByObserver(): void
    {
        static::creating(static function (Model $model) {
            if (empty($model->created_by) && Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }
}
