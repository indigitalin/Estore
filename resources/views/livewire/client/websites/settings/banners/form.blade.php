<div class="">
    @php
        $pageTitle = $this->banner ? 'Edit Menu' : 'Create Menu';
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
                <div class="col-span-6 xl:col-span-4">
                    <div
                        class="rounded-sm border border-stroke shadow-default mb-7  bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Banner information
                            </h3>
                        </div>
                        <div class="p-7 pt-0" x-data="{'type':'{{ $this->banner->type ?? 'image' }}'}">
                            <div class="flex flex-wrap -mx-2">
                                {{-- <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="type" :value="__('Type')" />
                                        <div class="flex items-center mb-2">
                                            <input @click="type='image'" type="radio" wire:model="form.type" name="type" value="image" class="cursor-pointer" id="image">
                                            <x-input-label class="mb-0 ms-2 cursor-pointer" for="image" :value="__('Image')" />
                                        </div>
                                        <div class="flex items-center">
                                            <input @click="type='video'" type="radio" wire:model="form.type" name="type" value="video" class="cursor-pointer" id="video">
                                            <x-input-label class="mb-0 ms-2 cursor-pointer" for="video" :value="__('Video')" />
                                        </div>
                                        <x-input-error :messages="$errors->get('form.type')" class="mt-2" />
                                    </div>
                                </div> --}}
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="title" :value="__('Title(optional)')" />
                                        <x-text-input placeholder="Title" wire:model="form.title" id="title"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.title')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="link" :value="__('Link(optional)')" />
                                        <x-text-input placeholder="Link" wire:model="form.link" id="link"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.link')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="placement" :value="__('Placement')" />
                                        <x-select id="placement" wire:model="form.placement" :options="[
                                            'slider' => 'Slider image',
                                            'breadcrumb' => 'Breadcrumb image'
                                        ]" :selected="$this->banner->placement ?? 'slider'" />
                                        <x-input-error :messages="$errors->get('form.placement')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="position" :value="__('Display order')" />
                                        <x-select id="position" wire:model="form.position" :options="range(1, 20)" :selected="$this->banner->position ?? '1'" />
                                        <x-input-error :messages="$errors->get('form.position')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <x-input-label :value="__('Status')" />
                                <x-toggle-switch :labelOn="'Active'" :labelOff="'Inactive'" id="status-toggle"
                                    wire:model="form.status" :label="__('Status')" :value="1" :checked="$this->banner && $this->banner->status == '1' ? true : false" />
                                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                            </div>
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate
                                    href="{{ route('client.websites.settings.banners.index', $this->website) }}"
                                    class="ms-auto me-2">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button>
                                    @if ($this->banner)
                                        Update banner
                                    @else
                                        Create banner
                                    @endif
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 xl:col-span-2">
                    <div class="sticky top-[110px]">
                        <div
                            class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark mb-7">
                            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                                <h3 class="font-medium text-black dark:text-white">
                                    Desktop image
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <x-image-upload :default="asset('/default.png')" :uploaded="$banner->desktop_url ?? asset('/default.png')"
                                    :name="'form.desktop'"></x-image-upload>
                            </div>
                        </div>
                        <div
                            class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark">
                            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                                <h3 class="font-medium text-black dark:text-white">
                                    Mobile image
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <x-image-upload :default="asset('/default.png')" :uploaded="$banner->mobile_url ?? asset('/default.png')"
                                    :name="'form.mobile'"></x-image-upload>
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
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                Toaster.success('API Key copied to clipboard.')
            });
        }
    </script>
@endpush
