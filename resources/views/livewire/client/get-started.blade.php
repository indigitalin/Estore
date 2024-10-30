<div class="p-6">
    <div class="text-xl font-semibold mb-5">Welcome!</div>
    <div>Thank you for being a part of our community! To help you get started, we invite you to take a guided tour to
        set up your company details.</div>

    <div class="flex items-center">
        <x-secondary-button class="ms-auto me-2" wire:click="$dispatch('closeModal'); $dispatch('welcome-message-shown')">
            No thanks
        </x-secondary-button>
        <x-primary-button wire:click="$dispatch('closeModal');$dispatch('welcome-message-shown')">
            Take a tour
        </x-primary-button>
    </div>
</div>
