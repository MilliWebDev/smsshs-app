<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Assignment;
use Livewire\Attributes\On;
class Assignmentview extends Component
{

    public $title,$description,$selectedId;

    public function createAssignment()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        // Logic to create the assignment
        // For example, you can save it to the database or perform any other action

        // Create the subject if it doesn't exist
        $assignment = Assignment::create([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        return redirect('/assignmentview')->with('message', 'Devoir ajouté'); // or wherever you want to redirect
    }


    #[On('update-created')]
    public function select($id)
    {
        $cleanId = strtolower(trim($id));
        $this->selectedId = $cleanId;
        $assignment = Assignment::find($id);
        if ($assignment) {
            $this->title = $assignment->title;
            $this->description = $assignment->description;
        }
    }

    public function delete($id)
    {
        $assignment = Assignment::find($id);
        if ($assignment) {
            $assignment->delete();
            return redirect('/assignmentview')->with('message', 'Devoir supprimé'); // or wherever you want to redirect
        }
    }

    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

      

        $assignment = Assignment::find($this->selectedId);
        if ($assignment) {
            $assignment->update([
                'title' => $this->title,
                'description' => $this->description,
            ]);
            return redirect('/assignmentview')->with('message', 'Devoir mis à jour'); // or wherever you want to redirect
        }
    }
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.assignmentview', [
            'assignments' => Assignment::all(),
        ]);
    }
}
