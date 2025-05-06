<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Assignment;
use App\Models\Semester;
use Livewire\Attributes\On;
class Assignmentview extends Component
{

    public $title,$description,$selectedId,$title_semester,$start_date,$end_date,$selectedSemesterId;

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


    public function createSemester()
    {
        $this->validate([
            'title_semester' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Logic to create the semester
        // For example, you can save it to the database or perform any other action

        // Create the subject if it doesn't exist
        $assignment = Semester::create([
            'name' => $this->title_semester,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        return redirect('/assignmentview')->with('message', 'Semestre ajouté'); // or wherever you want to redirect
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

    #[On('update2-created')]
    public function selectSemester($id)
    {
        $cleanId = strtolower(trim($id));
        $this->selectedSemesterId = $cleanId;
        $semester = Semester::find($id);
        if ($semester) {
            $this->title_semester = $semester->name;
            $this->start_date = $semester->start_date;
            $this->end_date = $semester->end_date;
        }
    }


    public function updateSemester()
    {
        $this->validate([
            'title_semester' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $semester = Semester::find($this->selectedSemesterId);
        if ($semester) {
            $semester->update([
                'name' => $this->title_semester,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
            return redirect('/assignmentview')->with('message', 'Semestre mis à jour'); // or wherever you want to redirect
        }
    }
    
    public function deleteSemester($id)
    {
        $semester = Semester::find($id);
        if ($semester) {
            $semester->delete();
            return redirect('/assignmentview')->with('message', 'Semestre supprimé'); // or wherever you want to redirect
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
            'semesters' => Semester::all(),
        ]);
    }
}
