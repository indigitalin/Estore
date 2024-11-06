<div class="">
    @php
        $pageTitle = $this->page ? 'Edit Menu' : 'Create Menu';
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
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="title" :value="__('Title')" />
                                        <x-text-input placeholder="Title" wire:model="form.title" id="title"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.title')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="banner_id" :value="__('Banner')" />
                                        <div x-data="{ banner_title: '{{ $page->banner->title ?? '' }}', banner_image: '{{ $page->banner->desktop_url ?? '' }}', show: false, banner_id: {{ $page->banner_id ?? 0 }} }" @click.away="show = false" class="relative">
                                            <div @click="show = !show"
                                                class="w-full flex items-center cursor-pointer rounded border border-stroke py-3 pl-3 pr-3 text-black bg-gray focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 block w-full">
                                                <div>
                                                    <div x-show="banner_id !=0">
                                                        <div class="flex items-center gap-3 cursor-pointer">
                                                            <div class="flex-shrink-0 ">
                                                                <img :src="banner_image"
                                                                    class="rounded-full w-8 h-8 object-cover rounded-full"
                                                                    alt="Brand" />
                                                            </div>
                                                            <div class="">
                                                                <p class="font-medium sm:block capitalize" x-text="banner_title"></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div x-show="banner_id ==0">
                                                        Select an option
                                                    </div>
                                                </div>
                                                <div class="ms-auto"><box-icon name='chevron-down'
                                                        color="#888"></box-icon></div>
                                            </div>
                                            <div x-show="show" style="display:none"
                                                class="z-[100] absolute rounded border border-stroke text-black bg-white focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 block w-full">
                                                <div @click="show = false; banner_id = 0; banner_title='';banner_image=''"
                                                    class="p-2 flex items-center gap-3 cursor-pointer">
                                                    <div class="flex-shrink-0 ">
                                                        <img src="{{ asset('default.png') }}"
                                                            class="rounded-full w-10 h-10 object-cover rounded-full"
                                                            alt="Brand" />
                                                    </div>
                                                    <div class="">
                                                        <p class="font-medium sm:block capitalize">
                                                            No image
                                                        </p>
                                                    </div>
                                                </div>
                                                @foreach ($banners as $banner)
                                                    <label for="banner_{{ $banner->id }}" class="block"
                                                        :class="{ 'bg-primary text-white': banner_id === {{ $banner->id }} }">
                                                        <div @click="show = false; banner_id = {{ $banner->id }};banner_title='{{ $banner->title }}';banner_image='{{ $banner->desktop_url }}'"
                                                            class="p-2 flex items-center gap-3 cursor-pointer">
                                                            <div class="flex-shrink-0 ">
                                                                <img src="{{ $banner->desktop_url }}"
                                                                    class="rounded-full w-10 h-10 object-cover rounded-full"
                                                                    alt="Brand" />
                                                            </div>
                                                            <div class="">
                                                                <p class="font-medium sm:block capitalize">
                                                                    {{ $banner->title }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <input x-show="false" type="radio" hidden
                                                            value="{{ $banner->id }}" wire:model="form.banner_id"
                                                            name="banner_id" id="banner_{{ $banner->id }}">
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('form.banner_id')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2" wire:ignore>
                                        <x-input-label for="content" :value="__('Content')" />
                                        <x-textarea id="content" wire:model.defer="content" placeholder="Content"
                                            wire:model="form.content" id="content" class="mt-1 block w-full"
                                            type="text" />
                                    </div>
                                    <x-input-error :messages="$errors->get('form.content')" class="mt-2" />
                                </div>
                            </div>
                            <div class="mt-5">
                                <x-input-label :value="__('Status')" />
                                <x-toggle-switch :labelOn="'Active'" :labelOff="'Inactive'" id="status-toggle"
                                    wire:model="form.status" :label="__('Status')" :value="1" :checked="$this->page && $this->page->status == '1' ? true : false" />
                                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                            </div>
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate
                                    href="{{ route('client.websites.settings.pages.index', $this->website) }}"
                                    class="ms-auto me-2">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button>
                                    @if ($this->page)
                                        Update page
                                    @else
                                        Create page
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
        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {
                @if($form->content)
                    editor.setData(@js($form->content));
                @endif
                editor.model.document.on('change:data', () => {
                    console.log(editor.getData());
                    @this.set('form.content', editor.getData());
                })
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
