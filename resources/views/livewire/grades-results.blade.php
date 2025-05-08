<div class="p-6 mt-10 bg-white rounded shadow">
    <div class="mb-4">
        <label class="block mb-2 text-lg font-bold text-gray-600">{{ __('Semestre choisis') }}</label>
        <select wire:model="selectedSemesterId" id="semester" class="w-full p-2 border border-gray-300 rounded">
            @foreach ($semesters as $semester)
                <option value="{{ $semester->id }}">
                    {{ $semester->name }} ({{ $semester->start_date }} - {{ $semester->end_date }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- Display Grades -->


    {{ $grades->links() }}

    <div class="overflow-x-auto border border-gray-300 rounded-lg">
        <table class="w-full border border-collapse table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Étudiant</th>
                    <th class="px-4 py-2 border">Matière</th>
                    <th class="px-4 py-2 border">Note</th>
                    <th class="px-4 py-2 border">Commentaire</th>
                    <th class="px-4 py-2 border">Enseignant</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grades->groupBy('student_id') as $studentGrades)
                    <tr class="font-bold bg-blue-100">
                        <td class="px-4 py-2 border" colspan="5">
                            {{ $studentGrades->first()->student->name }}
                        </td>
                    </tr>
                    @foreach ($studentGrades as $grade)
                        <tr>
                            <td class="px-4 py-2 border"></td> {{-- Empty for spacing --}}
                            <td class="px-4 py-2 border">{{ $grade->subject->name }}</td>
                            <td class="px-4 py-2 border">{{ $grade->score }} / 20</td>
                            <td class="px-4 py-2 border">{{ $grade->comment }}</td>
                            <td class="px-4 py-2 border">{{ $grade->teacher->name }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>


    </div>
</div>
