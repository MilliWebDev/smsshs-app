@props(['value'])

<label {{ $attributes->merge(['class' => 'block ftext-lg font-bold text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
