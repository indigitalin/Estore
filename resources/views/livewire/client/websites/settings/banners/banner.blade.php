<div class="p-6">
    <div class="w-fill relative">
        <img class="w-full h-60 object-cover" src="{{ $banner->desktop_url }}" alt="">
        <div class="flex w-full h-full bg-gray-700/20 items-center absolute top-0 start-0">
            <div class="m-auto text-2xl text-white">
                {{ $banner->title }}
            </div>
        </div>
    </div>
    <div class="flex items-center mt-5">
        <x-secondary-button class="ms-auto" wire:click="$dispatch('closeModal'); $dispatch('welcome-message-shown')">
            Close
        </x-secondary-button>
    </div>
</div>
