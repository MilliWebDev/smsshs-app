<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    //
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'classroom_id',
    ];

    public function classroom(): BelongsTo
    /**
     * Get the classroom that owns the student.
     */
    {
        return $this->belongsTo(Classe::class);
    }

    public function grades(): HasMany
    /**
     * Get the grades for the student.
     */
    {
        return $this->hasMany(Grade::class);
    }

    public function assignments(): BelongsToMany
    {
        return $this->belongsToMany(Assignment::class, 'grades')
            ->withPivot(['id', 'score', 'comment', 'teacher_id', 'subject_id', 'is_late', 'submitted_at'])
            ->withTimestamps();
    }
}
