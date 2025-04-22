<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Grade extends Component
{
    public $selectedClassSubjectTeacher;

    public $username;

    public $students = [];

    public function updatedSelectedClassSubjectTeacher($value)
    {
        $this->loadStudents();
    }

    public function mount()
    {
        $this->selectedClassSubjectTeacher = null;
        $this->students = [];
        $this->username = 3;
    }

    public function loadStudents()
    {
        $this->students = [];
        // dd($this->selectedClassSubjectTeacher);

        if ($this->selectedClassSubjectTeacher) {
            $selected = \App\Models\ClassSubjectTeacher::find($this->selectedClassSubjectTeacher);

            if ($selected && $selected->classroom_id) {
                $this->students = \App\Models\Student::where('classroom_id', $selected->classroom_id)->get();
            }
        }

        // dd($this->students);
        // dd($selected->classroom_id);
    }

    public function saveGrade($studentId, $assignmentId, $grade)
    {
        $grade = (int) $grade;
        $teacherId = auth()->user()->teacher->id;
        $subjectId = \App\Models\ClassSubjectTeacher::find($this->selectedClassSubjectTeacher)->subject_id;
        // dd($subjectId);

        // Validate score
        if (! is_numeric($grade) || $grade < 0 || $grade > 20) {
            $this->dispatch('notify');

            return;
        }

        $grade = \App\Models\Grade::updateOrCreate(
            [
                'student_id' => $studentId,
                'assignment_id' => $assignmentId,
                'teacher_id' => $teacherId,
                'subject_id' => $subjectId,
            ],
            [
                'score' => $grade,
            ]
        );

        // dd($grade);
    }

    #[Layout('layouts.app')]
    public function render()
    {

        // dd($this->selectedClassSubjectTeacher);
        $teacherId = auth()->user()->teacher->id;

        return view('livewire.grade', [
            'grades' => \App\Models\Grade::all(),
            'classSubjectTeachers' => \App\Models\ClassSubjectTeacher::with(['class', 'subject', 'teacher'])->where('teacher_id', $teacherId)->get(),
            'students' => $this->students,
            'assignments' => \App\Models\Assignment::all(),
        ]);
    }
}
