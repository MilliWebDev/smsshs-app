<div class="flex flex-col w-full h-full p-4 mt-8 space-y-4">
    <div>
        @if (session('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 30000)" x-show="show" x-transition
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
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 30000)" x-show="show" x-transition
                class="p-4 mb-4 text-sm text-green-600 bg-green-100 border border-green-400 rounded-lg" role="alert">
                <div class="flex items-center justify-between">
                    <span class="font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="text-green-600 hover:text-green-800">
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

            <span>{{ __('Create a classroom') }}</span>
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
                        <h1 class="text-xl font-medium text-gray-800 ">{{ __('Create a new classroom') }}</h1>

                        <button @click="modelOpen = false" class="text-gray-600 focus:outline-none hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>

                    <p class="mt-2 text-sm text-gray-500 ">
                        {{ __('Add teachers to classroom') }}
                    </p>

                    <form class="mt-5" wire:submit="createClassroom">

                        <div>
                            <label for="class_name"
                                class="block text-sm text-gray-700 capitalize dark:text-gray-200">{{ __('Classroom Name') }}</label>
                            <input placeholder="CE2" type="text" wire:model="class_name"
                                class="block w-full px-3 py-2 mt-2 text-gray-600 placeholder-gray-400 bg-white border border-gray-200 rounded-md focus:border-indigo-400 focus:outline-none focus:ring focus:ring-indigo-300 focus:ring-opacity-40">
                        </div>
                        <h1 class="block mt-5 text-sm text-gray-700 capitalize dark:text-gray-200">
                            {{ __('Select teachers') }}
                            <div class="mt-5 space-y-2">
                                @foreach ($teachers as $teacher)
                                    <label
                                        class="flex items-center p-2 space-x-2 border border-gray-200 rounded-md shadow-lg">
                                        <input type="checkbox" wire:model="selectedTeachers" value="{{ $teacher->id }}"
                                            class="text-indigo-600 border-gray-300 rounded shadow-sm">
                                        <span>{{ $teacher->user->last_name }}</span>
                                        <span>{{ $teacher->user->first_name }}</span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <h1 class="text-xs font-medium text-gray-400 uppercase">Permissions</h1>

                                <div class="mt-4 space-y-5">
                                    <div class="flex items-center space-x-3 cursor-pointer" x-data="{ show: true }"
                                        @click="show =!show">
                                        <div class="relative w-10 h-5 transition duration-200 ease-linear rounded-full"
                                            :class="[show ? 'bg-indigo-500' : 'bg-gray-300']">
                                            <label for="show" @click="show =!show"
                                                class="absolute left-0 w-5 h-5 mb-2 transition duration-100 ease-linear transform bg-white border-2 rounded-full cursor-pointer"
                                                :class="[show ? 'translate-x-full border-indigo-500' :
                                                    'translate-x-0 border-gray-300'
                                                ]"></label>
                                            <input type="checkbox" name="show"
                                                class="hidden w-full h-full rounded-full appearance-none active:outline-none focus:outline-none" />
                                        </div>

                                        <p class="text-gray-500">Can make task</p>
                                    </div>

                                    <div class="flex items-center space-x-3 cursor-pointer" x-data="{ show: false }"
                                        @click="show =!show">
                                        <div class="relative w-10 h-5 transition duration-200 ease-linear rounded-full"
                                            :class="[show ? 'bg-indigo-500' : 'bg-gray-300']">
                                            <label for="show" @click="show =!show"
                                                class="absolute left-0 w-5 h-5 mb-2 transition duration-100 ease-linear transform bg-white border-2 rounded-full cursor-pointer"
                                                :class="[show ? 'translate-x-full border-indigo-500' :
                                                    'translate-x-0 border-gray-300'
                                                ]"></label>
                                            <input type="checkbox" name="show"
                                                class="hidden w-full h-full rounded-full appearance-none active:outline-none focus:outline-none" />
                                        </div>

                                        <p class="text-gray-500">Can delete task</p>
                                    </div>

                                    <div class="flex items-center space-x-3 cursor-pointer" x-data="{ show: true }"
                                        @click="show =!show">
                                        <div class="relative w-10 h-5 transition duration-200 ease-linear rounded-full"
                                            :class="[show ? 'bg-indigo-500' : 'bg-gray-300']">
                                            <label for="show" @click="show =!show"
                                                class="absolute left-0 w-5 h-5 mb-2 transition duration-100 ease-linear transform bg-white border-2 rounded-full cursor-pointer"
                                                :class="[show ? 'translate-x-full border-indigo-500' :
                                                    'translate-x-0 border-gray-300'
                                                ]"></label>
                                            <input type="checkbox" name="show"
                                                class="hidden w-full h-full rounded-full appearance-none active:outline-none focus:outline-none" />
                                        </div>

                                        <p class="text-gray-500">Can edit task</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="px-3 py-2 text-sm tracking-wide text-white capitalize transition-colors duration-200 transform bg-indigo-500 rounded-md dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:bg-indigo-700 hover:bg-indigo-600 focus:outline-none focus:bg-indigo-500 focus:ring focus:ring-indigo-300 focus:ring-opacity-50">
                                    {{ __('Create a classroom') }}
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- create classroom ---->
    <div>
        @foreach ($teachers as $teacher)
            <ul wire:key={{ $teacher->id }}>
                <li>{{ $teacher->user->first_name }}</li>
            </ul>
        @endforeach
    </div>
    <div class="pb-4 overflow-x-auto ">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden border border-gray-300 rounded-lg">
                <table class="min-w-full table-auto rounded-xl">
                    <thead class="sticky top-0 z-10">
                        <tr class="bg-gray-50">
                            <th scope="col"
                                class="p-5 text-center whitespace-nowrap text-sm leading-6 font-semibold text-gray-900 capitalize min-w-[150px]">
                                Désignations</th>
                            <th scope="col"
                                class="p-5 text-sm font-semibold leading-6 text-center text-gray-900 capitalize whitespace-nowrap">
                                Quantité Stock</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300 ">
                        @foreach ($teachers as $teacher)
                            <tr class="transition-all duration-500 bg-white hover:bg-gray-50">
                                <td
                                    class="p-5 text-lg font-medium leading-6 text-center text-gray-900 whitespace-nowrap">
                                    {{ $teacher->user->first_name }} </td>
                                <td
                                    class="p-5 text-lg font-medium leading-6 text-center text-gray-900 whitespace-nowrap">
                                    <span
                                        class="px-5 bg-green-500 border rounded-full">{{ $teacher->user->last_name }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th
                        class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        Classroom
                    </th>
                    <th
                        class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        Teachers
                    </th>
                    <th
                        class="px-4 py-2 text-xs font-semibold tracking-wider text-left text-gray-600 uppercase border-b border-gray-200 bg-gray-50">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classrooms as $classroom)
                    <tr>
                        <td class="px-4 py-2 border-b border-gray-200">
                            {{ $classroom->name }}
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200">
                            @foreach ($classroom->teachers as $teacher)
                                <span
                                    class="inline-block px-2 py-1 mb-1 mr-1 text-xs text-blue-800 bg-blue-100 rounded-full">
                                    {{ $teacher->user->first_name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 border-b border-gray-200">
                            <a href="#" class="mr-2 text-blue-600 hover:text-blue-900">Edit</a>
                            <form action="#" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->

</div>
