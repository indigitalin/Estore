<div class="p-6">
    <div class="text-xl font-semibold mb-5">{{ $this->role ? 'Edit role' : 'Create new role' }}</div>
    <form wire:submit="{{ $this->role ? 'update' : 'store' }}">
        <div>
            <x-input-label for="name" :value="__('Role name')" />
            <x-text-input placeholder="Role name" wire:model="form.name" id="name" class="mt-1 block w-full" type="text" />
            <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
        </div> 
        <div class="mt-4">
            <x-input-label :value="__('Permissions')" />
            <div class="mt-4">
                @foreach ($permissions as $section => $items)
                    <div class="mb-4">
                        <div class="mb-2">{{ $section }}</div>
                        @foreach ($items as $permission)
                            <div>
                                <x-toggle-switch wire:model="form.permissions" label="{{ $permission->name }}" checked=""
                                    value="{{ $permission->id }}" id="permission_{{ $permission->id }}" />
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-5 flex">
            <x-primary-button class="ms-auto">
                @if ($this->role)
                    Update role
                @else
                    Create role
                @endif
            </x-primary-button>
        </div>
    </form>
</div>
