<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Attributes\On;

class StudentsView extends Component
{
    public $first_name;

    public $last_name;

    public $gender;

    public $date_of_birth;

    public $selectedClassroom;

    public $selectedId;

    public function createStudent()
    {

        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'selectedClassroom' => 'required|exists:classes,id',
        ]);
        try {
            Student::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'classroom_id' => $this->selectedClassroom,
            ]);

            return redirect('/students')->with('message', 'Apprenant ajouté');

            // Optionally reset form fields
            // $this->reset(['first_name', 'last_name', 'gender', 'date_of_birth', 'selectedClassroom']);

        } catch (\Exception $e) {
            return redirect('/students')->with('error', 'Apprenant non ajouté: '.$e->getMessage()); // Preserves form input on error
        }

    }

    #[On('update-created')]
    public function select($id)
    {
        $cleanId = strtolower(trim($id));
        $this->selectedId = $cleanId;
        $student = Student::find($id);
        if ($student) {
            $this->first_name = $student->first_name;
            $this->last_name = $student->last_name;
            $this->gender = $student->gender;
            $this->date_of_birth = $student->date_of_birth;
            $this->selectedClassroom = $student->classroom_id;
        }
    }
    public function delete($id)
    {
        $student = Student::find($id);
        if ($student) {
            $student->delete();
            return redirect('/students')->with('message', 'Apprenant supprimé');
        }
    }
    public function update()
    {

        
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'selectedClassroom' => 'required|exists:classes,id',
        ]);
        $student = Student::find($this->selectedId);
        if ($student) {
            $student->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'gender' => $this->gender,
                'date_of_birth' => $this->date_of_birth,
                'classroom_id' => $this->selectedClassroom,
            ]);
            return redirect('/students')->with('message', 'Apprenant mis à jour');
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.students-view', [
            'students' => \App\Models\Student::all(),
            'classrooms' => \App\Models\Classe::all(),
        ]);
    }
}
