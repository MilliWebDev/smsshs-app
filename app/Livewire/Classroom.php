<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Classroom extends Component
{
    public $selectedTeachers = [];

    public $class_name;

    public function createClassroom()
    {

        $this->validate([
            'class_name' => 'required|string|max:255',
            'selectedTeachers' => 'required|array',
        ]);

        try {
            DB::transaction(function () {
                // Create the classroom
                $class = \App\Models\Classe::create([
                    'name' => $this->class_name,
                ]);

                // Attach teachers (will only execute if class creation succeeded)
                $class->teachers()->attach($this->selectedTeachers);
            });

            return redirect('/classroom')->with('message', 'Class Created'); // or wherever you want to redirect

        } catch (\Exception $e) {

            return redirect('/classroom')->with('error', 'Class Not Created: '.$e->getMessage()); // Preserves form input on error
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.classroom', [
            'teachers' => \App\Models\Teachers::all(),
            'classrooms' => \App\Models\Classe::with('teachers')->get(),
        ]);
    }
}
