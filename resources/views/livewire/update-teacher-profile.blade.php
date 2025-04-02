<div>
    <x-form-section submit="update">
        <x-slot name="title">
            {{ __('Update Teacher Profile') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Update your account\'s teacher profile information.') }}
        </x-slot>

        <x-slot name="form">
            <div class="col-span-6 sm:col-span-4">
                <x-label for="address" value="{{ __('Address') }}" />
                <x-input id="address" type="text" class="block w-full mt-1" wire:model="address"
                    autocomplete="address" />
                <x-input-error for="address" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="contact_number" value="{{ __('Contact_Number') }}" />
                <x-input id="contact_number" type="text" class="block w-full mt-1" wire:model="contact_number"
                    autocomplete="contact_number" />
                <x-input-error for="contact_number" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Gender
                </label>
                <select id="gender" wire:model="gender"
                    class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                @error('gender')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-label for="hire_date" value="{{ __('Hire_Date') }}" />
                <x-input id="hire_date" type="date" class="block w-full mt-1" wire:model="hire_date"
                    autocomplete="hire_date" />
                <x-input-error for="hire_date" class="mt-2" />
            </div>

        </x-slot>

        <x-slot name="actions">
            <x-action-message class="me-3" on="saved">
                {{ __('Saved.') }}
            </x-action-message>

            <x-button wire:loading.attr="disabled" wire:target="photo">
                {{ __('Save') }}
            </x-button>
        </x-slot>
    </x-form-section>


</div>
