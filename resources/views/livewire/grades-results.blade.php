<div class="p-6 mt-10 bg-white rounded shadow">
    <div class="mb-4 rounded-lg bg-sky-100 p-4 z-10">
        <label class="block mb-2 text-lg font-bold text-gray-600">{{ __('Semestre choisis') }}</label>
        <select wire:model="selectedSemesterId" id="semester" class="w-1/4 p-2 border border-gray-300 rounded">
            @foreach ($semesters as $semester)
                <option value="{{ $semester->id }}">
                    {{ $semester->name }} ({{ $semester->start_date }} - {{ $semester->end_date }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- Display Grades -->

    <div class="overflow-x-auto border border-gray-300 rounded-lg">
        <div class="overflow-x-auto border border-gray-300 rounded-lg">
            @foreach ($grades->groupBy('subject_id') as $subjectId => $subjectGrades)
                <h2 class="text-lg font-bold mt-6">
                    Matière : {{ $subjectGrades->first()->subject->name }}
                </h2>
        
                @foreach ($subjectGrades->groupBy(fn($grade) => $grade->student->classroom->id ?? 'inconnu') as $classId => $classGrades)
                    <h3 class="text-md font-semibold text-blue-600 mt-2">
                        Classe : {{ $classGrades->first()->student->classroom->name ?? 'Inconnue' }}
                    </h3>
        
                    @php
                        $assignments = $classGrades->pluck('assignment')->unique('id');
                        $students = $classGrades->groupBy('student_id');
                    @endphp
        
                    <table class="table-auto w-full border mb-6">
                        <thead class="text-lg font-extrabold bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">{{ __('Étudiant') }}</th>
                                @foreach ($assignments as $assignment)
                                    <th class="border px-4 py-2">{{ $assignment->title }}</th>
                                @endforeach
                                @if(auth()->user()->role == 'admin')
                                    <th class="border px-4 py-2">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $studentId => $studentGrades)
                                <tr>
                                    <td class="border px-4 py-2">
                                        @if(auth()->user()->role == 'admin')
                                        <input
                                                type="checkbox"
                                                wire:model="selectedStudents"
                                                value="{{ $studentId }}"
                                                class="mr-2"
                                            >
                                            @endif
                                        <span class="text-lg font-bold">{{ $studentGrades->first()->student->first_name }}--{{$studentGrades->first()->student->last_name}}</span>
                                    </td>
        
                                    @foreach ($assignments as $assignment)
                                        @php
                                            $grade = $studentGrades->firstWhere('assignment_id', $assignment->id);
                                        @endphp
                                        <td class="border px-4 py-2 text-center">
                                            <span class="text-lg font-bold ">
                                                {{ $grade ? $grade->score : '-' }}
                                            </span>
                                        </td>
                                    @endforeach
        
                                    @if(auth()->user()->role == 'admin')
                                        <td class="border px-4 py-2">
                                            @php $grade = $studentGrades->first(); @endphp
                                            <button wire:click="savePDF('{{ $studentId }}')" class="text-blue-600 hover:underline mr-2">enregistrer</button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @endforeach
        </div>
        

    <div class="mt-4">
        {{ $grades->links() }}

    </div>
</div>
