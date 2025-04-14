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

            <span>{{ __('Create a Subject') }}</span>
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
                        <h1 class="text-xl font-medium text-gray-800 ">{{ __('Create a Subject') }}</h1>

                        <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>

                    <p class="mt-2 text-sm text-gray-500 ">
                        {{ __('Add Subject') }}
                    </p>

                    <form class="mt-5" wire:submit="createSubject">

                        <div>
                            <label for="subject_name"
                                class="block text-sm text-gray-700 capitalize dark:text-gray-200">{{ __('Subject Name') }}</label>
                            <input placeholder="Math" type="text" wire:model="subject_name"
                                class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                        </div>

                        <div class="mt-4">
                            <label for="subject_description"
                                class="block text-sm text-gray-700 capitalize dark:text-gray-200">{{ __('Subject Description') }}</label>
                            <textarea placeholder="Math is the study of numbers, shapes, and patterns." wire:model="subject_description"
                                class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40"></textarea>
                        </div>

                        <div class="w-full mt-4 ">
                            <div class="" x-data="{ show: false }">
                                <a href="#" x-on:click.prevent="show = !show"
                                    class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                    <span class="inline-block">{{ __('Select classes') }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        class="inline-block w-4 h-4 transition duration-150 transform stroke-current"
                                        x-bind:class="{ 'rotate-180': show }">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </a>
                                <div x-show.transition="show"
                                    class="relative z-20 flex flex-col w-full px-4 py-8 mt-1 bg-white border border-gray-600 rounded whitespace-nowrap">
                                    @foreach ($classes as $class)
                                        <div>
                                            <input wire:model='class_id' type="checkbox" name="type[]"
                                                value="{{ $class->id }}"
                                                class="inline-block mr-2" />{{ $class->name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="w-full mt-4 ">
                            <div class="" x-data="{ show: false }">
                                <a href="#" x-on:click.prevent="show = !show"
                                    class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                    <span class="inline-block">{{ __('Select teachers') }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        class="inline-block w-4 h-4 transition duration-150 transform stroke-current"
                                        x-bind:class="{ 'rotate-180': show }">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </a>
                                <div x-show.transition="show"
                                    class="relative z-20 flex flex-col w-full px-4 py-8 mt-1 bg-white border border-gray-600 rounded whitespace-nowrap">
                                    @foreach ($teachers as $item)
                                        <div>
                                            <input wire:model='teacher_id' type="checkbox" name="type[]"
                                                value="{{ $item->id }}"
                                                class="inline-block mr-2" />{{ $item->user->first_name }}
                                            {{ $item->user->last_name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <div class="flex justify-end mt-6">
                            <button type="submit"
                                class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                {{ __('Create a Subject') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- -->

    <div class="overflow-x-auto border border-gray-300 rounded-lg">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th
                        class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        {{ __('Subjects') }}
                    </th>
                    <th
                        class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        {{ __('Classes') }}
                    </th>
                    <th
                        class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        {{ __('Teachers') }}
                    </th>
                    <th
                        class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        {{ __('Actions') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td class="px-4 py-2 border-b border-gray-200">
                            {{ $subject->name }}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200">
                            <span
                                class="inline-block px-2 py-1 mb-1 mr-1 text-xs text-blue-800 bg-blue-100 rounded-full">
                                {{ $subject->name }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200">
                            <div class="" x-data="{ modelOpen2: false }">
                                <button @click="modelOpen2 = !modelOpen2"
                                    class="flex items-center space-x-2 text-blue-600 hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M17.414 2.586a2 2 0 010 2.828l-10 10a2 2 0 01-.707.414l-4 1a1 1 0 01-1.265-1.265l1-4a2 2 0 01.414-.707l10-10a2 2 0 012.828 0zm-3.121 2.121L4 15l-.707 2.828L6.828 16l10.293-10.293-3.828-3.828z" />
                                    </svg>
                                    <span>{{ __('Edit') }}</span>
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
                                                    {{ __('Create a new classroom') }}</h1>

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
                                                {{ __('Add teachers to classroom') }}
                                            </p>

                                            <form class="mt-5" wire:submit.prevent="update">

                                                <div>
                                                    <label for="class_name"
                                                        class="block text-sm text-gray-700 capitalize dark:text-gray-200">{{ __('Classroom Name') }}</label>
                                                    <input placeholder="CE2" type="text" wire:model="class_name"
                                                        class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                                                </div>

                                                <div class="mt-4">
                                                    <select wire:model="class_id"
                                                        class="block w-full p-2 border border-gray-300 rounded">
                                                        <option value="">Select Class</option>
                                                        @foreach ($classes as $class)
                                                            <option value="{{ $class->id }}">{{ $class->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="flex justify-end mt-6">
                                                    <button type="submit"
                                                        class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                                        {{ __('Update') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="flex items-center space-x-2 text-red-600 hover:text-red-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-2 h-2" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 011-1h6a1 1 0 011 1h3a1 1 0 110 2H2a1 1 0 110-2h3zm3 4a1 1 0 00-1 1v7a1 1 0 102 0V7a1 1 0 00-1-1zm4 0a1 1 0 00-1 1v7a1 1 0 102 0V7a1 1 0 00-1-1zM4 6a1 1 0 011 1v7a1 1 0 102 0V7a1 1 0 00-1-1H4zm10 0a1 1 0 011 1v7a1 1 0 102 0V7a1 1 0 00-1-1h-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>{{ __('Delete') }}</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="space-y-4">


        <select wire:model="class_id" class="w-full p-2 border rounded">
            <option value="">Select Class</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>

        <select wire:model="subject_id" class="w-full p-2 border rounded">
            <option value="">Select Subject</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>

        <select wire:model="teacher_id" class="w-full p-2 border rounded">
            <option value="">Select Teacher</option>
            @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->user->first_name }} {{ $teacher->user->last_name }}
                </option>
            @endforeach
        </select>

        <input type="text" wire:model="term" placeholder="Enter Term (e.g., Term 1)"
            class="w-full p-2 border rounded" />

        <button wire:click="assign" class="px-4 py-2 text-white bg-blue-500 rounded">Assign</button>
    </div>

</div>
