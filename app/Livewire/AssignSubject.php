<?php

namespace App\Livewire;

use App\Models\ClassSubjectTeacher;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class AssignSubject extends Component
{
    public $class_id = [];

    public $subject_name;

    public $subject_description;

    public $teacher_id = [];

    public $selectedId;

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
                        'subject_name' => 'Matière existante',
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

            return redirect('/assign-subject')->with('message', 'Matière ajoutée'); // or wherever you want to redirect

        } catch (\Exception $e) {

            return redirect('/assign-subject')->with('error', 'Matière non ajoutée: '.$e->getMessage()); // Preserves form input on error
        }
    }

    #[On('update-created')]
    public function select($id)
    {

        $cleanId = strtolower(trim($id));
        $this->selectedId = $cleanId;
        $subject = Subject::with(['classSubjectTeachers.class', 'classSubjectTeachers.teacher'])->where('id', $cleanId)->first();
        $this->subject_name = $subject->name;
        $this->subject_description = $subject->description;
        $this->class_id = $subject->classSubjectTeachers->pluck('classroom_id')->toArray();
        $this->teacher_id = $subject->classSubjectTeachers->pluck('teacher_id')->toArray();

    }

    public function update()
    {

        $record = \App\Models\Subject::find($this->selectedId);
        $record->name = $this->subject_name;
        $record->description = $this->subject_description;

        $this->validate([
            'subject_name' => 'required|string|max:255',
            'subject_description' => 'required|string|max:255',
            'class_id' => 'required|array',
            'teacher_id' => 'required|array',
        ]);

        try {
            DB::transaction(function () {
                $subject = Subject::findOrFail($this->selectedId);

                // Update subject info
                $subject->update([
                    'name' => $this->subject_name,
                    'description' => $this->subject_description,
                ]);

                // Re-create associations
                // Detach existing associations
                $subject->classSubjectTeachers()->delete();

                // Attach new associations
                foreach ($this->class_id as $class) {
                    foreach ($this->teacher_id as $teacher) {
                        $subject->classSubjectTeachers()->create([
                            'classroom_id' => $class,
                            'teacher_id' => $teacher,
                        ]);
                    }
                }
            });

            return redirect('/assign-subject')->with('message', 'Matière modifiée avec succès.');
        } catch (\Exception $e) {
            return redirect('/assign-subject')->with('error', 'Erreur: '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        $subject = \App\Models\Subject::find($id);

        if ($subject) {
            // Delete all related records in ClassSubjectTeacher
            $subject->classSubjectTeachers()->delete();

            // Delete the subject itself
            $subject->delete();

            return redirect('/assign-subject')->with('message', 'Matière et ses associations supprimées avec succès.');
        }

        return redirect('/assign-subject')->with('error', 'Erreur: La matière n\'existe pas.');

        return redirect('/assign-subject')->with('message', 'Matière supprimée avec succès.');
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
