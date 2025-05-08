<div>
    <div class="mb-4">
        <label for="semester">Choisir une session:</label>
        <select wire:model="selectedSemesterId" id="semester" class="p-2 border rounded">
            @foreach ($semesters as $semester)
                <option value="{{ $semester->id }}">
                    {{ $semester->name }} ({{ $semester->start_date }} - {{ $semester->end_date }})
                </option>
            @endforeach
        </select>
    </div>

    <!-- Display Grades -->
    <table class="w-full table-auto">
        <thead>
            <tr>
                <th>Élève</th>
                <th>Matière</th>
                <th>Professeur</th>
                <th>Note</th>
                <th>Commentaire</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grades as $grade)
                <tr>
                    <td>{{ $grade->student->name }}</td>
                    <td>{{ $grade->subject->name }}</td>
                    <td>{{ $grade->teacher->name }}</td>
                    <td>{{ $grade->score }}</td>
                    <td>{{ $grade->comment }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Aucun résultat pour cette session.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $grades->links() }}

    <div class="overflow-x-auto border border-gray-300 rounded-lg">
        <table class="w-full mt-6 border table-auto">
            <thead class="text-lg font-extrabold bg-gray-100">

            </thead>
            <tbody>

            </tbody>
        </table>

    </div>
</div>
