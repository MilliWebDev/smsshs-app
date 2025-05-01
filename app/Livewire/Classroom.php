<?php

namespace App\Livewire;

use App\Models\Classe;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Classroom extends Component
{
    use WithPagination;

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

            return redirect('/classroom')->with('message', 'Salle de classe crée'); // or wherever you want to redirect

        } catch (\Exception $e) {

            return redirect('/classroom')->with('error', 'Salle de classe non-crée '.$e->getMessage()); // Preserves form input on error
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

            return redirect('/classroom')->with('message', 'Salle de classe modifiée'); // or wherever you want to redirect

        } catch (\Exception $e) {

            return redirect('/classroom')->with('error', 'Salle de classe non crée: '.$e->getMessage()); // Preserves form input on error
        }
    }

    public function delete($id)
    {
        $record = \App\Models\Classe::find($id);
        $record->delete();

        return redirect('/classroom')->with('message', 'Salle de classe supprimée'); // or wherever you want to redirect
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.classroom', [
            'teachers' => \App\Models\Teachers::all(),
            'classrooms' => \App\Models\Classe::with('teachers')->paginate(10),
        ]);
    }
}
