<div class="flex flex-col w-full h-full p-4 mt-8 space-y-2">
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

            <span class='text-lg font-bold'>{{ __('Emploi du temps') }}</span>
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
                        <h1 class="text-xl font-medium text-gray-800 ">{{ __('Créer un emploi du temps') }}</h1>

                        <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>

                    <p class="mt-2 text-sm text-gray-500 ">
                        {{ __('Ajouter Emploi du temps') }}
                    </p>

                    <form class="mt-5" wire:submit="save">

                        <div class="mt-4">
                            <label
                                class="block text-lg font-bold text-gray-700 capitalize dark:text-gray-200">{{ __('Salle-Matière-Professeur') }}</label>
                            <select wire:model="classSubjectTeacherId"
                                class="w-full p-2 border rounded text-lg font-bold">
                                <option value="">Select</option>
                                @foreach ($classSubjectTeachers as $cst)
                                    <option value="{{ $cst->id }}">
                                        {{ $cst->class->name }} - {{ $cst->subject->name }}
                                        ({{ $cst->teacher->user->first_name }}-{{ $cst->teacher->user->last_name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('classSubjectTeacherId')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label
                                class="block text-lg font-bold text-gray-700 capitalize dark:text-gray-200">Day</label>
                            <select wire:model="day" class="w-full p-2 text-lg font-bold border rounded">
                                <option value="">Select Day</option>
                                @foreach ($days as $dayOption)
                                    <option value="{{ $dayOption }}">{{ $dayOption }}</option>
                                @endforeach
                            </select>
                            @error('day')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex gap-4 mt-4">
                            <div class="flex-1">
                                <label
                                    class="block text-lg font-bold text-gray-700 capitalize dark:text-gray-200">{{ __('Début du cours') }}</label>
                                <input type="time" wire:model="startTime"
                                    class="w-full text-lg font-bold p-2 border rounded" />
                                @error('startTime')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex-1">
                                <label
                                    class="block text-lg font-bold text-gray-700 capitalize dark:text-gray-200">{{ __('Fin du cours') }}</label>
                                <input type="time" wire:model="endTime"
                                    class="w-full text-lg font-bold p-2 border rounded" />
                                @error('endTime')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
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
</div>
