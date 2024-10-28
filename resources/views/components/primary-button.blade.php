<button wire:loading.attr="disabled" {{ $attributes->merge(['type' => 'submit', 'class' => 'capitalize flex justify-center rounded bg-primary px-6 py-2 font-medium text-gray hover:bg-opacity-90']) }}>
    {{ $slot }} <span wire:loading></span>
</button>
