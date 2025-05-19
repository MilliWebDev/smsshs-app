<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    //
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'coefficient',
    ];

    public function classSubjectTeachers(): HasMany
    {
        return $this->hasMany(ClassSubjectTeacher::class);
    }

    public function grades(): HasMany
    /**
     * Get the grades for the teacher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    {
        return $this->hasMany(Grade::class);
    }
}
