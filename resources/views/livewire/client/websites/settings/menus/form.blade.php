<div class="">
    @php
        $pageTitle = $this->menu ? 'Edit Menu' : 'Create Menu';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => route('client.index')],
            ['text' => 'Websites', 'link' => route('client.websites.index')],
            ['text' => $this->website->name, 'link' => route('client.websites.settings.index', $this->website)],
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
            <div class="grid grid-cols-6 gap-8">
                <div class="col-span-6 xl:col-span-6">
                    <div
                        class="rounded-sm border border-stroke shadow-default mb-7  bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Menu information
                            </h3>
                        </div>
                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="title" :value="__('Title')" />
                                        <x-text-input placeholder="Title" wire:model="form.title" id="title"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.title')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate href="{{ route('client.websites.settings.menus.index', $this->website) }}"
                                    class="ms-auto me-2">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button>
                                    @if ($this->menu)
                                        Update menu
                                    @else
                                        Create menu
                                    @endif
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<x-form-error :error="$errors" />
