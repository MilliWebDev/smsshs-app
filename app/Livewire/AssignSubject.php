<?php

namespace App\Livewire;

use App\Models\ClassSubjectTeacher;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class AssignSubject extends Component
{
    use WithPagination;

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
            'class_id.*' => 'string|exists:classes,id',
            'teacher_id.*' => 'string|exists:teachers,id',
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
        // Validate the updated data
        $this->validate([
            'subject_name' => 'required|string|max:255',
            'subject_description' => 'required|string|max:255',
            'class_id' => 'required|array',
            'teacher_id' => 'required|array',
        ]);

        // Find the subject record to update
        $subject = Subject::findOrFail($this->selectedId);

        try {
            DB::transaction(function () use ($subject) {
                // Update subject information
                $subject->update([
                    'name' => $this->subject_name,
                    'description' => $this->subject_description,
                ]);

                // dd(ClassSubjectTeacher::where('subject_id', $subject->id)->delete());
                // Remove old pivot records
                ClassSubjectTeacher::where('subject_id', $subject->id)->delete();

                // Ensure unique teacher-class combinations and create new pivot records
                $uniqueTeachers = array_unique($this->teacher_id);
                $uniqueClasses = array_unique($this->class_id);

                // dd($uniqueTeachers);
                foreach ($uniqueClasses as $class) {
                    foreach ($uniqueTeachers as $teacher) {
                        // This will prevent duplicate records from being inserted
                        ClassSubjectTeacher::firstOrCreate([
                            'classroom_id' => $class,
                            'subject_id' => $subject->id,
                            'teacher_id' => $teacher,
                        ]);
                    }
                }
            });

            // Redirect after success
            return redirect('/assign-subject')->with('message', 'Matière modifiée avec succès.');
        } catch (\Exception $e) {
            // Handle errors
            return redirect('/assign-subject')->with('error', 'Erreur: '.$e->getMessage());
        }
    }

    public function delete($id)
    {
        $subject = \App\Models\Subject::find($id);

        if ($subject) {
            // Delete all related records in ClassSubjectTeacher
            ClassSubjectTeacher::where('subject_id', $subject->id)->delete();

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
            'class_subject_teachers' => \App\Models\ClassSubjectTeacher::with(['class', 'subject', 'teacher'])->paginate(50),

        ]);
    }
}
