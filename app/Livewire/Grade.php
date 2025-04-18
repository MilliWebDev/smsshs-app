<?php

namespace App\Livewire;

use Livewire\Component;

class Grade extends Component
{
    public function render()
    {
        return view('livewire.grade', [
            'grades' => \App\Models\Grade::all(),
            'class_subject_teachers' => \App\Models\ClassSubjectTeacher::with(['class', 'subject', 'teacher'])->get(),
        ]);
    }
}
