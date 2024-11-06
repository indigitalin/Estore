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
                                        <x-image-select :selected="($this->page->banner_id ?? null)" :options="$banners" :name="'banner_id'"/>
                                        
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
