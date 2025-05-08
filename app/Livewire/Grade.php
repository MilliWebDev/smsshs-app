<?php

namespace App\Livewire;

use App\Models\Semester;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Grade extends Component
{
    use WithPagination;

    public $selectedClassSubjectTeacher;

    public $classroomId;

    public function updatedSelectedClassSubjectTeacher($value)
    {
        $selected = \App\Models\ClassSubjectTeacher::find($this->selectedClassSubjectTeacher);
        $this->classroomId = $selected?->classroom_id;
        $this->resetPage();
    }

    public function mount()
    {
        $this->selectedClassSubjectTeacher = null;

    }

    public function saveGrade($studentId, $assignmentId, $grade)
    {
        $grade = (int) $grade;
        $teacherId = auth()->user()->teacher->id;
        $subjectId = \App\Models\ClassSubjectTeacher::find($this->selectedClassSubjectTeacher)->subject_id;

        $currentDate = Carbon::today(); // or now() if you want time too

        $currentSemester = Semester::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->first();

        if (! $currentSemester) {
            throw new \Exception('Aucune session active trouvée pour la date actuelle.');
        }

        $semesterId = $currentSemester->id;
        // dd($semesterId);

        // Validate score
        if (! is_numeric($grade) || $grade < 0 || $grade > 20) {
            $this->dispatch('notify');

            return;
        }

        if ($grade == 0) {
            $description = 'Résultat de l\'élève est nul';
        } elseif ($grade < 10) {
            $description = 'Résultat de l\'élève est insuffisant';
        } elseif ($grade < 15) {
            $description = 'Résultat de l\'élève est moyen';
        } elseif ($grade < 18) {
            $description = 'Résultat de l\'élève est bon';
        } elseif ($grade < 20) {
            $description = 'Résultat de l\'élève est très bon';
        } else {
            $description = 'Résultat de l\'élève est excellent';
        }

        $grade = \App\Models\Grade::updateOrCreate(
            [
                'student_id' => $studentId,
                'assignment_id' => $assignmentId,
                'teacher_id' => $teacherId,
                'subject_id' => $subjectId,
                'semester_id' => $semesterId,

            ],
            [
                'score' => $grade,
                'comment' => $description,
            ]
        );

    }

    #[Layout('layouts.app')]
    public function render()
    {

        $teacherId = auth()->user()->teacher->id;

        $students = $this->classroomId
            ? \App\Models\Student::where('classroom_id', $this->classroomId)->paginate(20)
            : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 20);

        return view('livewire.grade', [
            'classSubjectTeachers' => \App\Models\ClassSubjectTeacher::with(['class', 'subject', 'teacher'])->where('teacher_id', $teacherId)->get(),
            'students' => $students,
            'assignments' => \App\Models\Assignment::all(),
        ]);
    }
}
