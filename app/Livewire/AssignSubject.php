<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class AssignSubject extends Component
{
    public $class_id;

    public $subject_name;

    public $subject_description;

    public $teacher_id;

    public function createSubject()
    {
        $this->validate([
            'subject_name' => 'required|string|max:255',
            'subject_description' => 'required|string|max:255',
        ]);
        try {
            \App\Models\Subject::create([
                'name' => $this->subject_name,
                'description' => $this->subject_description,
            ]);

            return redirect('/assign-subject')->with('message', 'Subject Assigned'); // or wherever you want to redirect

        } catch (\Exception $e) {

            return redirect('/assign-subject')->with('error', 'Subject Not Assigned: '.$e->getMessage()); // Preserves form input on error
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.assign-subject', [
            'subjects' => \App\Models\Subject::all(),
            'teachers' => \App\Models\Teachers::all(),
            'classes' => \App\Models\Classe::all(),
        ]);
    }
}
