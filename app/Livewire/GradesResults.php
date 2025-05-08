<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class GradesResults extends Component
{
    public function mount()
    {
        $this->selectedSemesterId = \App\Models\Semester::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first()?->id;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $teacherId = auth()->user()->teacher->id;

        return view('livewire.grades-results', [
            'semesters' => \App\Models\Semester::orderBy('start_date')->get(),
            'grades' => \App\Models\Grade::with(['student', 'subject', 'teacher'])
                ->where('semester_id', $this->selectedSemesterId)
                ->paginate(20),
        ]);
    }
}
