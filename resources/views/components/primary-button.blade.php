<button wire:loading.attr="disabled"
    {{ $attributes->merge(['type' => 'submit', 'class' => 'relative capitalize flex justify-center rounded bg-primary px-6 py-2 font-medium text-gray hover:bg-opacity-90']) }}>
    <span wire:loading.class="opacity-0">{{ $slot }} </span>
    <span class="absolute w-full top-0 start-0 h-100 flex items-center">
        <span wire:loading class="m-auto">
            <img class="w-11 opacity-80" src="https://raw.githubusercontent.com/n3r4zzurr0/svg-spinners/main/preview/3-dots-fade-white-36.svg" alt="">
        </span>
    </span>
</button>
