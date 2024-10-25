<div class="">
    @php
        $pageTitle = $role ? 'Edit Role' : 'Create Role';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => roleRoute('{role}.index')],
            ['text' => 'Roles', 'link' => roleRoute('{role}.roles.index')],
            ['text' => $pageTitle, 'link' => ''],
        ];
        $pageDescription = '';
        $rightSideBtnText = '';
        $rightSideBtnRoute = '';
    @endphp
    <x-admin-breadcrumb :pageTitle=$pageTitle :navigationLinks=$navigationLinks :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText :rightSideBtnRoute=$rightSideBtnRoute />

    <div class="">
        <form wire:submit.prevent="save">
            <div class="grid grid-cols-5 gap-8">
                <div class="col-span-5 xl:col-span-5">
                    <div class="rounded-sm border shadow-default border-stroke bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Role information
                            </h3>
                        </div>

                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="mt-4 w-full md:w-1/2 p-2">
                                    <x-input-label for="name" :value="__('Role name')" />
                                    <x-text-input placeholder="Role name" wire:model="form.name" id="name"
                                        class="mt-1 block w-full" type="text" />
                                    <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <x-input-label :value="__('Permissions')" />
                                <div class="mt-4">
                                    @foreach ($permissions as $section => $items)
                                        <div class="mb-4">
                                            <div class="mb-2">{{ $section }}</div>
                                            @foreach ($items as $permission)
                                                <div>
                                                    <x-toggle-switch wire:model="form.permissions"
                                                        label="{{ $permission->name }}" checked=""
                                                        value="{{ $permission->id }}"
                                                        id="permission_{{ $permission->id }}" />
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate href="{{ roleRoute('{role}.roles.index') }}"
                                    class="ms-auto me-2">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button>
                                    @if ($this->role)
                                        Update role
                                    @else
                                        Create role
                                    @endif
                                </x-primary-button>
                            </div>
                        </div>

                    </div>

                </div>
        </form>
    </div>
