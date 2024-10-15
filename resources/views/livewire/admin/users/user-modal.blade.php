<div class="p-6">
    <form wire:submit="save">
        <div class="grid grid-cols-2 gap-4">
            <div class="">
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input wire:model="form.first_name" id="first_name" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.first_name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input wire:model="form.last_name" id="last_name" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.last_name')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input wire:model="form.phone" id="phone" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.v')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="form.email" id="email" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input wire:model="form.password" id="password" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="confirm" :value="__('Confirm Password')" />
                <x-text-input wire:model="form.confirm" id="confirm" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.v')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="type" :value="__('User Type')" />
                <x-text-input wire:model="form.type" id="type" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.type')" class="mt-2" />
            </div>
            <div class="mt-5">
                <x-toggle-switch id="status-toggle" :label="__('Status')" value="1" :checked="true" />

                {{-- <x-input-label for="status" :value="__('Status')" />
                <x-text-input wire:model="form.status" id="status" class="mt-1 block w-full" type="status" />
                <x-input-error :messages="$errors->get('form.status')" class="mt-2" /> --}}
            </div>
            <div class="mt-4">
                <x-primary-button>
                    Save
                </x-primary-button>
            </div>
        </div>

    </form>
</div>
