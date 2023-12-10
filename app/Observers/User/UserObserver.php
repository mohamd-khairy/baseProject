<?php

namespace App\Observers\User;

use App\Models\Cause;

class UserObserver
{
    /**
     * @param Cause $cause
     * @return void
     */
    public function created(Cause $cause): void
    {
        $cause->calenders()->updateOrCreate([
            'start_date' => $cause->date,
            'end_date' => $cause->date,
            'details' => "تم اضافة قضية برقم ({$cause->cause_number})"
        ]);
    }
}
