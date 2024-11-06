<div class="">
    @php
        $pageTitle = $this->store ? 'Edit Store' : 'Create Store';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => route('client.index')],
            ['text' => 'Stores', 'link' => route('client.stores.index')],
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
                                Store information
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

                            </div>
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="address" :value="__('Address')" />
                                        <x-text-input placeholder="Address" wire:model="form.address" id="address"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.address')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="city" :value="__('City')" />
                                        <x-text-input placeholder="City" wire:model="form.city" id="city"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.city')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="postcode" :value="__('Postcode')" />
                                        <x-text-input placeholder="Postcode" x-mask="******" wire:model="form.postcode"
                                            id="postcode" class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.postcode')" class="mt-2" />
                                    </div>
                                </div>
                                @if (config('app.country'))
                                    <input type="hidden" name="form.country_id"
                                        wire:model="form.country_id" value="{{ config('app.country') }}">
                                @else
                                    <div class="w-full md:w-1/2 p-2">
                                        <div class="mt-2">
                                            <x-input-label for="country_id" :value="__('Country')" />
                                            <x-select id="country_id" wire:change="updateStates"
                                                wire:model="form.country_id" :options="$countries" :selected="$this->form->country_id" />
                                            <x-input-error :messages="$errors->get('form.country_id')" class="mt-2" />
                                        </div>
                                    </div>
                                @endif
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="state_id" :value="__('State')" />
                                        <x-select id="state_id" wire:model="form.state_id" :options="$this->states"
                                            :selected="$this->form->state_id" />
                                        <x-input-error :messages="$errors->get('form.state_id')" class="mt-2" />
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
                                <div class="w-full md:w-1/1"></div>
                                {{-- <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="latitude" :value="__('Latitude')" />
                                        <x-text-input placeholder="Latitude" wire:model="form.latitude" id="latitude"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.latitude')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="longitude" :value="__('Longitude')" />
                                        <x-text-input placeholder="Longitude" wire:model="form.longitude" id="longitude"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.longitude')" class="mt-2" />
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div
                        class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Store login
                            </h3>
                        </div>
                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
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
                                        <x-input-label for="password" :value="__('Password')" />
                                        <x-password-input placeholder="Password" wire:model="form.password"
                                            id="password" class="mt-1 block w-full" />
                                        <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="confirm_password" :value="__('Confirm Password')" />
                                        <x-password-input placeholder="Confirm password"
                                            wire:model="form.confirm_password" id="confirm_password"
                                            class="mt-1 block w-full" />
                                        <x-input-error :messages="$errors->get('form.confirm_password')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            @if ($store)
                                <div class="mt-4">
                                    <div class="flex items-center">
                                        <x-input-label :value="__('API Key')" />
                                    </div>
                                    <div class="text-semibold cursor-pointer" x-tooltip="tooltip"
                                        @click="copyToClipboard(apiKey)" x-data="{ tooltip: 'Copy API Key', apiKey: '{{ $store->api_key }}' }">
                                        {{ str_repeat('*', strlen($store->api_key) - 10) . substr($store->api_key, -10) }}
                                        <box-icon class="cursor-pointer" name='copy'></box-icon>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-5">
                                <x-input-label :value="__('Status')" />
                                <x-toggle-switch id="status-toggle" wire:model="form.status" :label="__('Status')" :labelOn="'Active'" :labelOff="'Inactive'"
                                    :value="1" :checked="$this->store && $this->store->status == '1' ? true : false" />
                                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                            </div>
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate href="{{ route('client.stores.index') }}"
                                    class="ms-auto me-2">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button>
                                    @if ($this->store)
                                        Update store
                                    @else
                                        Create store
                                    @endif
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-6 xl:col-span-2">
                    <div class="sticky top-[110px]">
                        <div
                            class="rounded-sm border border-stroke shadow-default mb-7  bg-white dark:border-strokedark dark:bg-boxdark">
                            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                                <h3 class="font-medium text-black dark:text-white">
                                    Store logo
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <x-image-upload :default="$this->store->default_logo_url ?? file_url('/default.png')" :uploaded="$this->store->logo_url ?? file_url('/default.png')"
                                    :name="'form.logo'"></x-image-upload>
                            </div>
                        </div>
                        <div
                            class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark">
                            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                                <h3 class="font-medium text-black dark:text-white">
                                    Store location
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <x-map-picker :latitude="$this->store->latitude ?? '20.5937'" :longitude="$this->store->longitude ?? '78.9629'"/>
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
