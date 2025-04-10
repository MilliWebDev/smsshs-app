<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classe extends Model
{
    //
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
    ];

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teachers::class, 'teacher_class', 'class_id', 'teacher_id')->withTimestamps();
    }

    public function students(): HasMany
    /**
     * Get all of the students for the Classe
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    {
        return $this->hasMany(Student::class);
    }

    public function classSubjectTeachers(): HasMany
    /**
     * Get all of the classSubjectTeachers for the Classe
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    {
        return $this->hasMany(ClassSubjectTeacher::class);
    }
}
