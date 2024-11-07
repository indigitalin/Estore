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
                            {{-- <div x-data="menuComponent()">
                                <div class="mt-10">
                                    <template x-for="(menu, index) in menus" :key="menu.key">
                                        <div x-data="{ showEdit: false, title: menu.title }" class="border rounded p-2 mb-2">
                                            <div class="flex items-center">
                                                <div x-text="title" class="font-normal"></div>
                                                <div class="ms-auto flex items-center">
                                                    <div x-data="{ tooltip: 'Add sub menu' }" x-tooltip="tooltip"
                                                        class="flex items-center cursor-pointer justify-center w-9 h-9 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg toggle-full-view hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 dark:bg-gray-800 focus:outline-none dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 me-2">
                                                        <box-icon size="20px" color="#888"
                                                            name="plus"></box-icon>
                                                    </div>
                                                    <div @click="showEdit = !showEdit" x-data="{ tooltip: 'Edit menu' }"
                                                        x-tooltip="tooltip"
                                                        class="flex items-center cursor-pointer justify-center w-9 h-9 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg toggle-full-view hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 dark:bg-gray-800 focus:outline-none dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 me-2">
                                                        <box-icon size="20px" color="#888"
                                                            name="edit"></box-icon>
                                                    </div>
                                                    <div @click="deleteMenu(menu.key)" x-data="{ tooltip: 'Delete menu' }"
                                                        x-tooltip="tooltip"
                                                        class="flex items-center cursor-pointer justify-center w-9 h-9 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg toggle-full-view hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 dark:bg-gray-800 focus:outline-none dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 me-2">
                                                        <box-icon size="20px" color="#888"
                                                            name="trash"></box-icon>
                                                    </div>
                                                    <div @click="moveUp(menu.key)" x-data="{ tooltip: 'Move up' }" x-tooltip="tooltip"
                                                        class="flex items-center cursor-pointer justify-center w-9 h-9 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg toggle-full-view hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 dark:bg-gray-800 focus:outline-none dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 me-2">
                                                        <box-icon size="20px" color="#888"
                                                            name="chevron-up"></box-icon>
                                                    </div>
                                                    <div @click="moveDown(menu.key)" x-data="{ tooltip: 'Move down' }" x-tooltip="tooltip"
                                                        class="flex items-center cursor-pointer justify-center w-9 h-9 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg toggle-full-view hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 dark:bg-gray-800 focus:outline-none dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                                        <box-icon size="20px" color="#888"
                                                            name="chevron-down"></box-icon>
                                                    </div>
                                                </div>
                                            </div>
                                            <div x-show="showEdit" style="display: none">
                                                <div class="flex items-center mt-2">
                                                    <input placeholder="Menu title" x-model="title"
                                                        :value="menu.title" type="text"
                                                        class="rounded flex-1 border border-stroke p-1 px-2 font-medium text-black bg-gray focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary  block w-full">
                                                    <input placeholder="Link" :value="menu.link" type="text"
                                                        class="ms-2 flex-1 rounded border border-stroke p-1 px-2 font-medium text-black bg-gray focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary  block w-full">
                                                    <div @click="showEdit = !showEdit" x-data="{ tooltip: 'Done editing' }"
                                                        x-tooltip="tooltip"
                                                        class="flex items-center cursor-pointer justify-center w-9 h-9 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg toggle-full-view hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 dark:bg-gray-800 focus:outline-none dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 ms-2">
                                                        <box-icon size="20px" color="#888"
                                                            name='check'></box-icon>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    <div class="flex">
                                        <div @click="addNewMenu()" x-data="{ tooltip: 'Add new menu' }" x-tooltip="tooltip"
                                            class="flex items-center cursor-pointer justify-center w-11 h-11 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg toggle-full-view hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 dark:bg-gray-800 focus:outline-none dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 me-2">
                                            <box-icon color="#888" name="plus"></box-icon>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate
                                    href="{{ route('client.websites.settings.menus.index', $this->website) }}"
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
@push('scripts')
    <script>
        function menuComponent() {
            return {
                menus: @js($menus),
                addNewMenu() {
                    this.menus.push({
                        title: 'New Menu',
                        link: '#',
                        key: Math.floor(100000 + Math.random() * 900000),
                        childs : [],
                    });
                    // Ensure DOM is updated before Alpine does anything further
                    this.$nextTick(() => {
                        // Code here will run after the DOM is updated
                    });
                },
                deleteMenu(key) {
                    const index = this.menus.findIndex(menu => menu.key === key);
                    if (index !== -1) {
                        this.menus.splice(index, 1);
                    }
                },
                moveUp(key) {
                    const index = this.menus.findIndex(menu => menu.key === key);
                    if (index > 0) {
                        [this.menus[index - 1], this.menus[index]] = [this.menus[index], this.menus[index - 1]];
                    }
                },

                // Move item down by swapping with the next item
                moveDown(key) {
                    const index = this.menus.findIndex(menu => menu.key === key);
                    if (index < this.menus.length - 1) {
                        [this.menus[index], this.menus[index + 1]] = [this.menus[index + 1], this.menus[index]];
                    }
                }
            };
        }
    </script>
@endpush
