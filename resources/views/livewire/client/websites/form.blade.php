<div class="">
    @php
        $pageTitle = $this->website ? 'Edit Website' : 'Create Website';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => route('client.index')],
            ['text' => 'Websites', 'link' => route('client.websites.index')],
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
                                Website information
                            </h3>
                        </div>
                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input placeholder="Name" wire:model="form.name" id="name"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2"></div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="website_link" :value="__('Website')" />
                                        <x-text-input placeholder="Website" wire:model="form.website_link" id="website_link"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.website_link')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input type="email" placeholder="Email" wire:model="form.email"
                                            id="email" class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="phone" :value="__('Phone')" />
                                        <x-text-input placeholder="Phone number" x-mask="99999 99999"
                                            wire:model="form.phone_number" id="phone" class="mt-1 block w-full"
                                            type="text" />
                                        <x-input-error :messages="$errors->get('form.phone')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            @if ($website)
                                <div class="mt-4">
                                    <div class="flex items-center">
                                        <x-input-label :value="__('API Key')" />
                                    </div>
                                    <div class="text-semibold cursor-pointer" x-tooltip="tooltip" @click="copyToClipboard(apiKey)"
                                        x-data="{ tooltip: 'Copy API Key', apiKey: '{{ $website->api_key }}' }">
                                        {{ str_repeat('*', strlen($website->api_key) - 10) . substr($website->api_key, -10) }}
                                        <box-icon class="cursor-pointer" name='copy'></box-icon>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-5">
                                <x-toggle-switch id="status-toggle" wire:model="form.status" :label="__('Status')"
                                    :value="1" :checked="$this->website && $this->website->status == '1' ? true : false" />
                                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                            </div>
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate href="{{ route('client.websites.index') }}"
                                    class="ms-auto me-2">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button>
                                    @if ($this->website)
                                        Update website
                                    @else
                                        Create website
                                    @endif
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 xl:col-span-2">
                    <div class="sticky top-[110px]">
                        <div
                            class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark">
                            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                                <h3 class="font-medium text-black dark:text-white">
                                    Website logo
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <x-image-upload :default="$this->website->default_logo_url ?? asset('/default.png')" :uploaded="$this->website->logo_url ?? asset('/default.png')"
                                    :name="'form.logo'"></x-image-upload>
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
