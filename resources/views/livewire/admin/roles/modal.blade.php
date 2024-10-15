<div class="p-6">
    <form wire:submit="store">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="form.name" id="name" class="mt-1 block w-full" type="text" />
            <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
        </div>
        <div class="mt-4 flex">
            <x-primary-button class="ms-auto">
                Create role
            </x-primary-button>
        </div>
    </form>
</div>
