<div class="">
    @php
        $pageTitle = $client ? 'Edit Client' : 'Create Client';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => route('admin.index')],
            ['text' => 'Clients', 'link' => route('admin.clients.index')],
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
                        class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark mb-7">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Personal information
                            </h3>
                        </div>

                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="first_name" :value="__('First Name')" />
                                        <x-text-input placeholder="First name" wire:model="form.firstname"
                                            id="first_name" class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.firstname')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="last_name" :value="__('Last Name')" />
                                        <x-text-input placeholder="Last name" wire:model="form.lastname" id="last_name"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.lastname')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full  p-2">
                                    <div class="mt-2">
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input :disabled="$client" placeholder="Email" wire:model="form.email"
                                            id="email" class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                                        @if ($client)
                                            <p class="text-sm mt-2 flex items-center text-gray-500"> <box-icon
                                                    color="#777" size="16px" name='error-circle'
                                                    class="me-1"></box-icon> Email can
                                                not be changed. This user have to login to change their email.</p>
                                        @endif
                                    </div>
                                </div>
                                @if (!$client)
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
                                @endif
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

                        </div>
                    </div>
                    <div
                        class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Company information
                            </h3>
                        </div>
                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="business_name" :value="__('Business Name')" />
                                        <x-text-input placeholder="Business name" wire:model="form.business_name"
                                            id="business_name" class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.business_name')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="last_name" :value="__('Industry')" />
                                        <x-select id="industry_id" wire:model="form.industry_id" :options="$industries"
                                            :selected="$this->form->industry_id" />
                                        <x-input-error :messages="$errors->get('form.industry_id')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/1 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="description" :value="__('Description')" />
                                        <x-textarea rows="5" placeholder="Description"
                                            wire:model="form.description" id="description" class="mt-1 block w-full"
                                            type="text" />
                                        <x-input-error :messages="$errors->get('form.description')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="pan" :value="__('PAN')" />
                                        <x-text-input placeholder="PAN number" x-mask="**********"
                                            wire:model="form.pan" id="pan" class="mt-1 block w-full"
                                            type="text" />
                                        <x-input-error :messages="$errors->get('form.pan')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="gst" :value="__('GST')" />
                                        <x-text-input placeholder="GST number" x-mask="***************"
                                            wire:model="form.gst" id="gst" class="mt-1 block w-full"
                                            type="text" />
                                        <x-input-error :messages="$errors->get('form.gst')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="whatsapp" :value="__('Whatsapp')" />
                                        <x-text-input placeholder="Whatsapp number" x-mask="99999 99999"
                                            wire:model="form.whatsapp_number" id="whatsapp"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.whatsapp')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="website" :value="__('Website')" />
                                        <x-text-input placeholder="Website" wire:model="form.website" id="website"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.website')" class="mt-2" />
                                    </div>
                                </div>
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
                                        <x-text-input placeholder="Postcode" x-mask="******"
                                            wire:model="form.postcode" id="postcode" class="mt-1 block w-full"
                                            type="text" />
                                        <x-input-error :messages="$errors->get('form.postcode')" class="mt-2" />
                                    </div>
                                </div>
                                @if (config('app.country'))
                                    <input wire:init="updateStates" type="hidden" name=""
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
                                        <x-select id="state_id" wire:model="form.state_id" :options="$states"
                                            :selected="$this->form->state_id" />
                                        <x-input-error :messages="$errors->get('form.state_id')" class="mt-2" />
                                    </div>
                                </div>

                            </div>
                            <div class="mt-5">
                                <x-toggle-switch id="status-toggle" wire:model="form.status" :label="__('Status')"
                                    :value="1" :checked="$client && $client->status == '1' ? true : false" />
                                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                            </div>
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate href="{{ route('admin.clients.index') }}"
                                    class="ms-auto me-2">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button>
                                    @if ($this->client)
                                        Update client
                                    @else
                                        Create client
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
                                    Profile photo
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <x-image-upload :default="$client->user->default_picture_url ?? asset('/default.png')" :uploaded="$client->user->picture_url ?? asset('/default.png')" :name="'form.picture'"></x-image-upload>
                            </div>
                        </div>
                        <div
                            class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark">
                            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                                <h3 class="font-medium text-black dark:text-white">
                                    Company logo
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <x-image-upload :default="$client->default_logo_url ?? asset('/default.png')" :uploaded="$client->logo_url ?? asset('/default.png')" :name="'form.logo'"></x-image-upload>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
