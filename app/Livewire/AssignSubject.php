<?php

namespace App\Livewire;

use App\Models\ClassSubjectTeacher;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AssignSubject extends Component
{
    public $class_id = [];

    public $subject_name;

    public $subject_description;

    public $teacher_id = [];

    public function createSubject()
    {

        $this->validate([
            'subject_name' => 'required|string|max:255',
            'subject_description' => 'required|string|max:255',
            'class_id' => 'required|array',
            'teacher_id' => 'required|array',
        ]);
        try {
            DB::transaction(function () {
                // Check if the subject already exists
                $existingSubject = Subject::where('name', $this->subject_name)->first();

                if ($existingSubject) {
                    // Throw an exception to stop everything
                    throw ValidationException::withMessages([
                        'subject_name' => 'The subject already exists.',
                    ]);
                }

                // Create the subject if it doesn't exist
                $subject = Subject::create([
                    'name' => $this->subject_name,
                    'description' => $this->subject_description,
                ]);

                foreach ($this->class_id as $class) {
                    foreach ($this->teacher_id as $teacher) {
                        ClassSubjectTeacher::create([
                            'classroom_id' => $class,
                            'subject_id' => $subject->id,
                            'teacher_id' => $teacher,
                        ]);
                    }
                }
            });

            return redirect('/assign-subject')->with('message', 'Subject Assigned'); // or wherever you want to redirect

        } catch (\Exception $e) {

            return redirect('/assign-subject')->with('error', 'Subject Not Assigned: '.$e->getMessage()); // Preserves form input on error
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.assign-subject', [

            'teachers' => \App\Models\Teachers::all(),
            'subjects' => \App\Models\Subject::all(),
            'classes' => \App\Models\Classe::all(),
            'class_subject_teachers' => \App\Models\ClassSubjectTeacher::with(['class', 'subject', 'teacher'])->get()
                ->groupBy('subject_id'),
        ]);
    }
}
