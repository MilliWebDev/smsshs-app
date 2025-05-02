<?php

namespace App\Livewire;

use App\Models\ClassSubjectTeacher;
use App\Models\Timetable;
use Livewire\Attributes\Layout;
use Livewire\Component;

class TimeTableView extends Component
{
    public $classSubjectTeacherId;

    public $day;

    public $startTime;

    public $endTime;

    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

    public function save()
    {
        try {
            $this->validate([
                'classSubjectTeacherId' => 'required|exists:class_subject_teachers,id',
                'day' => 'required|in:'.implode(',', $this->days),
                'startTime' => 'required|date_format:H:i',
                'endTime' => 'required|date_format:H:i|after:startTime',
            ]);

            // Get the classroom ID from the ClassSubjectTeacher
            $classSubjectTeacher = ClassSubjectTeacher::find($this->classSubjectTeacherId);

            if (! $classSubjectTeacher) {
                $this->addError('classSubjectTeacherId', 'Invalid Class Subject Teacher ID.');

                return;
            }

            $classroomId = $classSubjectTeacher->classroom_id;

            // Check for overlapping slots for the same classroom and day
            $overlap = Timetable::whereHas('classSubjectTeacher', function ($query) use ($classroomId) {
                $query->where('classroom_id', $classroomId);
            })
                ->where('day', $this->day)
                ->where(function ($query) {
                    $query->whereBetween('start_time', [$this->startTime, $this->endTime])
                        ->orWhereBetween('end_time', [$this->startTime, $this->endTime])
                        ->orWhere(function ($q) {
                            $q->where('start_time', '<=', $this->startTime)
                                ->where('end_time', '>=', $this->endTime);
                        });
                })
                ->exists();

            if ($overlap) {
                $this->addError('startTime', 'This time slot overlaps with an existing one.');

                return;
            }

            // Create the timetable slot
            Timetable::updateOrCreate([
                'class_subject_teacher_id' => $this->classSubjectTeacherId,
                'day' => $this->day,
                'start_time' => $this->startTime,
                'end_time' => $this->endTime,
            ]);

            $this->reset(['day', 'startTime', 'endTime', 'classSubjectTeacherId']);

            return redirect('/timetable')->with('message', 'Emploi du temps mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect('/timetable')->with('error', 'Emploie du temps non mise à jour: '.$e->getMessage());
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.time-table-view', [
            'classSubjectTeachers' => \App\Models\ClassSubjectTeacher::with(['class', 'subject', 'teacher'])->get(),
        ]);
    }
}
