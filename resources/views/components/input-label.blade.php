@props(['value'])

<label {{ $attributes->merge(['class' => 'mb-3 block text-sm font-medium text-black dark:text-white']) }}>
    {{ $value ?? $slot }}
</label>
