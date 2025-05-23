<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use PDF;

class GradesResults extends Component
{

    public $selectedSemesterId;

    public function savePDF($id){
        $cleanId = strtolower(trim($id));
        $grades = \App\Models\Grade::where('student_id', $cleanId)->with(['student', 'subject', 'teacher'])->get() ->groupBy(fn($grade) => $grade->subject->name);
        //dd($grades);
         // Load the view into a PDF
        $pdf = PDF::loadView('pdf.report', ['data' => $grades,'semester' => \App\Models\Semester::find($this->selectedSemesterId)]);
        // Stream the PDF in the browser
        return response()->stream(
            function () use ($pdf) {
                echo $pdf->output();
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="produits.pdf"',
            ]
        );

    }
    public function mount()
    {
        $this->selectedSemesterId = \App\Models\Semester::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first()?->id;
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $teacherId = auth()->user()->teacher->id ?? null;

        if (auth()->user()->role == 'admin') {
            $teacherId = null;
        }

        $query = \App\Models\Grade::with(['student', 'subject', 'teacher'])
        ->where('semester_id', $this->selectedSemesterId);

        if ($teacherId) {
         $query->where('teacher_id', $teacherId);
        }


        return view('livewire.grades-results', [
            'semesters' => \App\Models\Semester::orderBy('start_date')->get(),
            'grades' => $query->paginate(20),
        ]);
    }
}
