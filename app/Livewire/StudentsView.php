<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class StudentsView extends Component
{
    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.students-view');
    }
}
