<button {{ $attributes->merge(['type' => 'button', 'class' => 'flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white']) }}>
    {{ $slot }}
</button>
