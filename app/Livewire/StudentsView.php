<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Attributes\Layout;
use Livewire\Component;

class StudentsView extends Component
{
    public $first_name;

    public $last_name;

    public $gender;

    public $date_of_birth;

    public $selectedClassroom;

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

            return redirect('/students')->with('message', 'Students added successfully');

            // Optionally reset form fields
            // $this->reset(['first_name', 'last_name', 'gender', 'date_of_birth', 'selectedClassroom']);

        } catch (\Exception $e) {
            return redirect('/students')->with('error', 'Student Not Created: '.$e->getMessage()); // Preserves form input on error
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
