<div class="flex flex-col w-full h-full p-4 mt-8 space-y-4">
    <div>
        @if (session('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 10000)" x-show="show" x-transition
                class="p-4 mb-4 text-sm text-green-600 bg-green-100 border border-green-400 rounded-lg" role="alert">
                <div class="flex items-center justify-between">
                    <span class="font-medium">{{ session('message') }}</span>
                    <button @click="show = false" class="text-green-600 hover:text-green-800">
                        &times;
                    </button>
                </div>
            </div>
        @endif
    </div>

    <div>
        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 10000)" x-show="show" x-transition
                class="p-4 mb-4 text-sm text-red-600 bg-green-100 border border-red-400 rounded-lg" role="alert">
                <div class="flex items-center justify-between">
                    <span class="font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="text-red-600 hover:text-red-800">
                        &times;
                    </button>
                </div>
            </div>
        @endif
    </div>


    <div class="flex justify-end w-full h-10" x-data="{ modelOpen: false }">
        <button @click="modelOpen =!modelOpen"
            class="flex items-center justify-center px-3 py-2 space-x-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d=" M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                    clip-rule="evenodd" />
            </svg>

            <span>{{ __('Ajouter apprenant') }}</span>
        </button>

        <div x-show="modelOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                <div x-cloak @click="modelOpen = false" x-show="modelOpen"
                    x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40" aria-hidden="true"></div>

                <div x-cloak x-show="modelOpen" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                    <div class="flex items-center justify-between space-x-4">
                        <h1 class="text-xl font-medium text-gray-800 ">{{ __('Ajouter apprenant') }}</h1>

                        <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>

                    <p class="mt-2 text-sm text-gray-500 ">
                        {{ __('Ajouter apprenant') }}
                    </p>

                    <form class="mt-5" wire:submit="createStudent" id="createStudent">
                        <div>
                            <x-label for="first_name" value="{{ __('Prénoms') }}" />
                            <x-input id="first_name" class="block w-full mt-1" type="text" name="first_name"
                                wire:model='first_name' :value="old('first_name')" required autofocus
                                autocomplete="first_name" />
                        </div>

                        <div class="mt-4">
                            <x-label for="last_name" value="{{ __('Nom de famille') }}" />
                            <x-input id="last_name" class="block w-full mt-1" type="text" name="last_name"
                                wire:model='last_name' :value="old('last_name')" required autofocus autocomplete="last_name" />
                        </div>

                        <div class="mt-4">
                            <x-label for="gender" value="{{ __('Sexe') }}" />
                            <select wire:model='gender' name="classroom_id"
                                class="block w-full p-2 mt-1 border border-gray-300 rounded">
                                <option>{{ __('Select a gender') }}</option>

                                <option value="male">{{ __('Masculin') }}</option>
                                <option value="female">{{ __('Féminin') }}</option>

                            </select>
                        </div>

                        <div class="mt-4">
                            <x-label for="date_of_birth" value="{{ __('Date de naissance') }}" />
                            <x-input id="date_of_birth" class="block w-full mt-1" type="date" name="date_of_birth"
                                wire:model='date_of_birth' :value="old('date_of_birth')" required autofocus
                                autocomplete="date_of_birth" />
                        </div>

                        <div class="mt-4">
                            <x-label for="classroom" value="{{ __('Salle de classe') }}" />
                            <select wire:model="selectedClassroom"
                                class="block w-full p-2 border border-gray-300 rounded">
                                <option value="">Select a classroom</option>
                                @foreach ($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-3 py-2 text-lg font-bold tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                {{ __('Validez') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- create classroom ---->


    <div class="overflow-x-auto border border-gray-300 rounded-lg">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th
                        class="px-4 py-2 text-lg font-bold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        {{ __('Apprenants') }}
                    </th>
                    <th
                        class="px-4 py-2 text-lg font-bold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        {{ __('Salle de classes') }}
                    </th>

                    <th
                        class="px-4 py-2 text-lg font-bold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        {{ __('Sexe') }}
                    </th>
                    <th
                        class="px-4 py-2 text-lg font-bold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($students->isEmpty())
                <tr>
                <td colspan="3" class="px-4 py-2 text-center text-gray-500">
                    {{ __('Aucun information disponible.') }}
                </td>
                </tr>
               @else
                @foreach ($students as $student)
                    <tr class="border">
                        <td class="px-4 py-2 border-b border-gray-200">
                            {{ $student->first_name }} {{ $student->last_name }}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200">
                            <span
                                class="inline-block px-2 py-1 mb-1 mr-1 text-xs text-blue-800 bg-blue-100 rounded-full">
                                {{ $student->classroom->name }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200">
                            <span
                                class="inline-block px-2 py-1 mb-1 mr-1 text-xs text-blue-800 bg-blue-100 rounded-full">
                                {{ $student->gender }}
                            </span>
                        </td>
                        <td class="flex items-baseline gap-2 px-4 py-2">
                            <div class="" x-data="{ modelOpen2: false }">
                                <button wire:click="$dispatch('update-created', { id:' {{ $student->id }}' })"
                                    @click="modelOpen2 = !modelOpen2"
                                    class="flex items-center space-x-2 text-blue-600 hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M17.414 2.586a2 2 0 010 2.828l-10 10a2 2 0 01-.707.414l-4 1a1 1 0 01-1.265-1.265l1-4a2 2 0 01.414-.707l10-10a2 2 0 012.828 0zm-3.121 2.121L4 15l-.707 2.828L6.828 16l10.293-10.293-3.828-3.828z" />
                                    </svg>
                                    <span>{{ __('Modifier') }}</span>
                                </button>

                                <div x-show="modelOpen2" class="fixed inset-0 z-50 overflow-y-auto"
                                    aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div
                                        class="flex items-end justify-center min-h-screen px-4 text-center md:items-center sm:block sm:p-0">
                                        <div x-cloak @click="modelOpen2 = false" x-show="modelOpen2"
                                            x-transition:enter="transition ease-out duration-300 transform"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="transition ease-in duration-200 transform"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-40"
                                            aria-hidden="true"></div>

                                        <div x-cloak x-show="modelOpen2"
                                            x-transition:enter="transition ease-out duration-300 transform"
                                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                            x-transition:leave="transition ease-in duration-200 transform"
                                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                            class="inline-block w-full max-w-xl p-8 my-20 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl 2xl:max-w-2xl">
                                            <div class="flex items-center justify-between space-x-4">
                                                <h1 class="text-xl font-medium text-gray-800 ">
                                                    {{ __('Créer un apprenant') }}</h1>

                                                <button @click="modelOpen2 = false"
                                                    class="text-gray-600 focus:outline-none hover:text-gray-700">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <p class="mt-2 text-sm text-gray-500 ">
                                                {{ __('Ajouter un apprenant') }}
                                            </p>

                                            <form class="mt-5" wire:submit.prevent="update">

                                                <div>
                                                    <x-label for="first_name" value="{{ __('Prénoms') }}" />
                                                    <x-input id="first_name" class="block w-full mt-1" type="text"
                                                        name="first_name" wire:model='first_name' :value="old('first_name')"
                                                        required autofocus autocomplete="first_name" />
                                                </div>

                                                <div class="mt-4">
                                                    <x-label for="last_name" value="{{ __('Nom de famille') }}" />
                                                    <x-input id="last_name" class="block w-full mt-1" type="text"
                                                        name="last_name" wire:model='last_name' :value="old('last_name')"
                                                        required autofocus autocomplete="last_name" />
                                                </div>

                                                <div class="mt-4">
                                                    <x-label for="gender" value="{{ __('Sexe') }}" />
                                                    <select wire:model='gender' name="classroom_id"
                                                        class="block w-full p-2 mt-1 border border-gray-300 rounded">
                                                        <option>{{ __('Select a gender') }}</option>

                                                        <option value="male">{{ __('Masculin') }}</option>
                                                        <option value="female">{{ __('Féminin') }}</option>

                                                    </select>
                                                </div>

                                                <div class="mt-4">
                                                    <x-label for="date_of_birth"
                                                        value="{{ __('Date de naissance') }}" />
                                                    <x-input id="date_of_birth" class="block w-full mt-1"
                                                        type="date" name="date_of_birth"
                                                        wire:model='date_of_birth' :value="old('date_of_birth')" required autofocus
                                                        autocomplete="date_of_birth" />
                                                </div>

                                                <div class="mt-4">
                                                    <x-label for="classroom" value="{{ __('Salle de classe') }}" />
                                                    <select wire:model="selectedClassroom"
                                                        class="block w-full p-2 border border-gray-300 rounded">
                                                        <option value="">Select a classroom</option>
                                                        @foreach ($classrooms as $classroom)
                                                            <option value="{{ $classroom->id }}">
                                                                {{ $classroom->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="flex justify-end mt-6">
                                                    <button type="submit"
                                                        class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                        {{ __('Validez') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button wire:click="delete('{{ $student->id }}')"
                                wire:confirm.prompt='{{ __('Êtes-vous sûr de vouloir supprimer ce devoir ?') }}\n\n{{ __('appuyer supprimer ') }}|supprimer'
                                class="flex items-center space-x-2 text-red-600 hover:text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M 10 2 L 9 3 L 3 3 L 3 5 L 21 5 L 21 3 L 15 3 L 14 2 L 10 2 z M 4.3652344 7 L 5.8925781 20.263672 C 6.0245781 21.253672 6.877 22 7.875 22 L 16.123047 22 C 17.121047 22 17.974422 21.254859 18.107422 20.255859 L 19.634766 7 L 4.3652344 7 z">
                                    </path>
                                </svg>
                                <span>{{ __('Supprimer') }}</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->

</div>
