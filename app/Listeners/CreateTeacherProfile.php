<?php

namespace App\Listeners;

use App\Events\TeacherCreated;
use App\Models\Teachers;
use Illuminate\Support\Facades\Log;

class CreateTeacherProfile
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TeacherCreated $event): void
    {
        //

        Teachers::create([
            'user_id' => $event->user->id,
            'gender' => null,
            'contact_number' => 'Not specified',
            'hire_date' => null,
            'address' => 'Not specified',
        ]);

        Log::info('Teacher profile created for user ID: '.$event->user->id);

    }
}
