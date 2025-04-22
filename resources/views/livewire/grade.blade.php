<div class="p-6 bg-white rounded shadow">
    <input type="number" wire:model.live='username' />
    Todo character length: <h2 x-text={{ $username }}></h2>
    <h2 class="text-2xl font-semibold text-gray-700">Manage Grades</h2>

    <div class="my-4">
        <label class="block mb-2 font-medium text-gray-600">Select Class & Subject</label>
        <select wire:model.live="selectedClassSubjectTeacher" class="w-full p-2 border border-gray-300 rounded">
            <option value="">Select Class and Subject</option>
            @foreach ($classSubjectTeachers as $cst)
                <option value="{{ $cst->id }}">
                    {{ $cst->class->name }} - {{ $cst->subject->name }}
                </option>
            @endforeach
        </select>
        <p>Selected ID: {{ $selectedClassSubjectTeacher }}</p>
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
                    @if ($students)
                        @foreach ($students as $student)
                            <tr class="border-t">
                                <td class="p-2">{{ $student->first_name }}
                                    {{ $student->last_name }}</td>
                                @foreach ($assignments as $assignment)
                                    <td class="p-2">
                                        <input type="number" min="0" max="20"
                                            wire:change.debounce.500ms="saveGrade('{{ $student->id }}', '{{ $assignment->id }}', $event.target.value)"
                                            class="w-16 px-2 py-1 border rounded" />
                                        <div x-on:notify="notify('New post: ' + $event.detail.title)"></div>

                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    @endif
</div>
