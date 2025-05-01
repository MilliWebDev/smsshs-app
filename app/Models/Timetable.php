<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timetable extends Model
{
    //
    protected $fillable = [
        'class_subject_teacher_id',
        'day',
        'start_time',
        'end_time',
    ];

    public function classSubjectTeacher(): BelongsTo
    /**
     * Get the class subject teacher that owns the timetable.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    {
        return $this->belongsTo(ClassSubjectTeacher::class);
    }
}
