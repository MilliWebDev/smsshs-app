<div class="p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-semibold text-gray-700">Manage Grades</h2>

    <div class="my-4">
        <label class="block mb-2 font-medium text-gray-600">Select Class & Subject</label>
        <select wire:model="selectedClassSubjectTeacher" class="w-full p-2 border border-gray-300 rounded">
            <option value="">-- Choose --</option>
            @foreach ($classSubjectTeachers as $cst)
                <option value="{{ $cst->id }}">
                    {{ $cst->class->name }} - {{ $cst->subject->name }} ({{ $cst->teacher->user->name }})
                </option>
            @endforeach
        </select>
    </div>

    @if ($students && $assignments)
        <div class="overflow-x-auto">
            <table class="w-full mt-6 border table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Student</th>
                        @foreach ($assignments as $assignment)
                            <th class="p-2 text-left">{{ $assignment->title }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="border-t">
                            <td class="p-2">{{ $student->user->name }}</td>
                            @foreach ($assignments as $assignment)
                                <td class="p-2">
                                    <input type="number" min="0" max="20"
                                        wire:change.debounce.500ms="saveGrade({{ $student->id }}, {{ $assignment->id }}, $event.target.value)"
                                        class="w-16 px-2 py-1 border rounded" />
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
