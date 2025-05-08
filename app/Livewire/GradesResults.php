<?php

namespace App\Livewire;

use Livewire\Component;

class GradesResults extends Component
{
    public function mount()
    {
        $this->selectedSemesterId = \App\Models\Semester::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first()?->id;
    }

    public function render()
    {
        return view('livewire.grades-results', [
            'semesters' => \App\Models\Semester::orderBy('start_date')->get(),
            'grades' => \App\Models\Grade::with(['student', 'subject', 'teacher'])
                ->where('semester_id', $this->selectedSemesterId)
                ->orderBy('student_id')
                ->paginate(20),
        ]);
    }
}
