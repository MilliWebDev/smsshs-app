<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assignment extends Model
{
    //
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'title',
        'description',
    ];

    public function grades(): HasMany
    /**
     * Get the grades for the teacher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    {
        return $this->hasMany(Grade::class);
    }

    public function students(): BelongsToMany
    /**
     * The students that belong to the assignment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    {
        return $this->belongsToMany(Student::class, 'grades')
            ->withPivot(['id', 'score', 'comment', 'teacher_id', 'subject_id', 'is_late', 'submitted_at'])
            ->withTimestamps();
    }
}
