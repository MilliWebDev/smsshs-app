<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassSubjectTeacher extends Model
{
    protected $fillable = [
        'classroom_id',
        'subject_id',
        'teacher_id',
    ];

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classe::class, 'classroom_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teachers::class, 'teacher_id');
    }

    public function timetable(): BelongsTo
    {
        return $this->hasMany(Timetable::class);
    }
}
