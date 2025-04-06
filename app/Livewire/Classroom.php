<?php

namespace App\Livewire;

use App\Models\Classe;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Classroom extends Component
{
    public $selectedTeachers = [];

    public $class_name;

    public $selectedId;

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

    #[On('update-created')]
    public function select($id)
    {

        $cleanId = strtolower(trim($id));
        $this->selectedId = $cleanId;
        $classroom = Classe::with('teachers')->where('id', $cleanId)->first();
        $this->class_name = $classroom->name;

        $this->selectedTeachers = $classroom->teachers->pluck('id')->toArray();

    }

    public function update()
    {

        $record = \App\Models\Classe::find($this->selectedId);
        $record->name = $this->class_name;

        $this->validate([
            'class_name' => 'required|string|max:255',
            'selectedTeachers' => 'required|array',
        ]);

        try {
            DB::transaction(function () {
                // Create the classroom
                $class = \App\Models\Classe::find($this->selectedId);
                $class->update([
                    'name' => $this->class_name,
                ]);

                // Attach teachers (will only execute if class creation succeeded)
                $class->teachers()->sync($this->selectedTeachers);
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
