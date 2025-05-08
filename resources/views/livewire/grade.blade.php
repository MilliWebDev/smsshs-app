<div class="p-6 mt-10 bg-white rounded shadow">

    <div class="my-4">
        <label
            class="block mb-2 text-lg font-bold text-gray-600">{{ __('Sélectionner une classe et une matière') }}</label>
        <select wire:model.live="selectedClassSubjectTeacher" class="w-full p-2 border border-gray-300 rounded">
            <option value="">{{ __('Sélectionner une classe et une matière') }}</option>
            @foreach ($classSubjectTeachers as $cst)
                <option value="{{ $cst->id }}">
                    <span class='text-lg font-bold'> {{ $cst->class->name }} - {{ $cst->subject->name }} </span>
                </option>
            @endforeach
        </select>
    </div>

    @if ($students && $assignments)
        <div class="overflow-x-auto">
            <table class="w-full mt-6 border table-auto">
                <thead class="text-lg font-extrabold bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Student</th>
                        @foreach ($assignments as $assignment)
                            <th class="p-2 text-left">{{ $assignment->title }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @if ($students && $students->count() > 0)
                        @foreach ($students as $student)
                            <tr class="border-t">
                                <td class="p-2 "><span class='text-lg font-bold'>{{ $student->first_name }}
                                        {{ $student->last_name }}</span></td>
                                @foreach ($assignments as $assignment)
                                    <td class="p-2">
                                        <input type="number" min="0" max="20"
                                            wire:change.debounce.500ms="saveGrade('{{ $student->id }}', '{{ $assignment->id }}', $event.target.value)"
                                            class="w-20 px-3 py-2 transition duration-200 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />

                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ $assignments ? $assignments->count() + 1 : 2 }}"
                                class="p-2 text-lg font-bold text-center">
                                {{ __('Aucun apprenant ou matière trouvé') }}.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="mt-4">
                {{ $students->links() }}
            </div>

        </div>
    @endif
    <Livewire:@livewire('grades-results') </div>
