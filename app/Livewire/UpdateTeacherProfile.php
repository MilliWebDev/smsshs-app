<?php

namespace App\Livewire;

use App\Models\Teachers;
use Livewire\Component;

class UpdateTeacherProfile extends Component
{
    public Teachers $teacher;

    public $address = '';

    public $contact_number = '';

    public $gender = '';

    public $hire_date = '';

    public function mount()
    {
        $this->teacher = Teachers::where('user_id', auth()->user()->id)->first();
        $this->address = $this->teacher->address;
        $this->contact_number = $this->teacher->contact_number;
        $this->gender = $this->teacher->gender;
        $this->hire_date = $this->teacher->hire_date;
    }

    public function update()
    {
        // Validate the input
        $this->validate([
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'hire_date' => 'required|date',

        ]);

        // Update the user's email and name
        $this->teacher->forceFill([
            'address' => $this->address,
            'gender' => $this->gender,
            'contact_number' => $this->contact_number,
            'hire_date' => $this->hire_date,
        ])->save();

        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.update-teacher-profile');
    }
}
