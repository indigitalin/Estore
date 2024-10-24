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
            <div class="grid grid-cols-5 gap-8">
                <div class="col-span-5 xl:col-span-3">
                    <div class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark mb-7">
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
                                        @if($client)
                                        <p class="text-sm mt-2 flex items-center text-gray-500"> <box-icon
                                            color="#777" size="16px" name='error-circle' class="me-1"></box-icon> Email can
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
                    <div class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark">
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
                                        <x-text-input placeholder="Address"
                                            wire:model="form.address" id="address" class="mt-1 block w-full"
                                            type="text" />
                                        <x-input-error :messages="$errors->get('form.address')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="city" :value="__('City')" />
                                        <x-text-input placeholder="City"
                                            wire:model="form.city" id="city" class="mt-1 block w-full"
                                            type="text" />
                                        <x-input-error :messages="$errors->get('form.city')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="postcode" :value="__('Postcode')" />
                                        <x-text-input placeholder="Postcode" x-mask="******"
                                            wire:model="form.postcode" id="postcode"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.postcode')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="country_id" :value="__('Country')" />
                                        <x-select id="country_id" wire:change="updateStates" wire:model="form.country_id" :options="$countries"
                                            :selected="$this->form->country_id" />
                                        <x-input-error :messages="$errors->get('form.country_id')" class="mt-2" />
                                    </div>
                                </div>
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
                <div class="col-span-5 xl:col-span-2">
                    <div class="sticky top-[110px]">
                        <div x-data="imagePreviewer('{{ $client ? $client->user->picture_url : asset('/default.png') }}')"
                            class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark mb-7">
                            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                                <h3 class="font-medium text-black dark:text-white">
                                    Profile photo
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <div class="items-center w-full gap-3 justify-center">
                                    <div class="mb-4 flex items-center gap-3">
                                        <div class="rounded-full">
                                            <img :src="imagePreview" class="w-15 h-15 rounded-full object-cover"
                                                alt="client photo">
                                        </div>
                                        <div>
                                            <span class="mb-1.5 font-medium text-black dark:text-white">Edit
                                                photo</span>
                                            <label class="text-blue-600 cursor-pointer block" for="picture">Upload
                                                photo</label>
                                        </div>
                                    </div>
                                    <div>
                                        <div @dragover.prevent @dragleave="dragging = false"
                                            @drop.prevent="handleDrop($event)"
                                            class="relative block w-full cursor-pointer appearance-none rounded border border-dashed border-primary bg-gray px-4 py-4 dark:bg-meta-4 sm:py-7.5">
                                            <input @change="fileChosen($event)" type="file"
                                                wire:model="form.picture" id="picture"
                                                accept="image/jpeg, image/png, image/webp, image/jpg"
                                                class="absolute inset-0 z-50 m-0 h-full w-full cursor-pointer p-0 opacity-0 outline-none">
                                            <div class="flex flex-col items-center justify-center space-y-3">
                                                <span
                                                    class="flex h-10 w-10 items-center justify-center rounded-full border border-stroke bg-white dark:border-strokedark dark:bg-boxdark">
                                                    <box-icon name='upload' color="black"></box-icon>
                                                </span>
                                                <p class="text-sm font-medium">
                                                    <span class="text-primary">Click to upload</span>
                                                    or drag and drop
                                                </p>
                                                <p class="mt-1.5 text-sm font-medium">
                                                    PNG, JPG, WEBP (max 2mb)
                                                </p>
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('form.picture')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div x-data="imagePreviewer('{{ $client ? $client->logo_url : asset('/default.png') }}')"
                            class="rounded-sm border border-stroke shadow-default  bg-white dark:border-strokedark dark:bg-boxdark">
                            <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                                <h3 class="font-medium text-black dark:text-white">
                                    Company logo
                                </h3>
                            </div>
                            <div class="p-7 pt-0 mt-4">
                                <div class="items-center w-full gap-3 justify-center">
                                    <div class="mb-4 flex items-center gap-3">
                                        <div class="rounded-full">
                                            <img :src="imagePreview" class="w-15 h-15 rounded-full object-cover"
                                                alt="client photo">
                                        </div>
                                        <div>
                                            <span class="mb-1.5 font-medium text-black dark:text-white">Edit
                                                logo</span>
                                            <label class="text-blue-600 cursor-pointer block" for="logo">Upload
                                                logo</label>
                                        </div>
                                    </div>
                                    <div>
                                        <div @dragover.prevent @dragleave="dragging = false"
                                            @drop.prevent="handleDrop($event)"
                                            class="relative block w-full cursor-pointer appearance-none rounded border border-dashed border-primary bg-gray px-4 py-4 dark:bg-meta-4 sm:py-7.5">
                                            <input @change="fileChosen($event)" type="file" wire:model="form.logo"
                                                id="logo" accept="image/jpeg, image/png, image/webp, image/jpg"
                                                class="absolute inset-0 z-50 m-0 h-full w-full cursor-pointer p-0 opacity-0 outline-none">
                                            <div class="flex flex-col items-center justify-center space-y-3">
                                                <span
                                                    class="flex h-10 w-10 items-center justify-center rounded-full border border-stroke bg-white dark:border-strokedark dark:bg-boxdark">
                                                    <box-icon name='upload' color="black"></box-icon>
                                                </span>
                                                <p class="text-sm font-medium">
                                                    <span class="text-primary">Click to upload</span>
                                                    or drag and drop
                                                </p>
                                                <p class="mt-1.5 text-sm font-medium">
                                                    PNG, JPG, WEBP (max 2mb)
                                                </p>
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->get('form.logo')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function imagePreviewer(defaultImage) {
                return {
                    imagePreview: defaultImage, // Initial preview URL from backend
                    dragging: false, // State for drag events
                    defaultImage: '123',
                    fileChosen(event) {
                        const file = event.target.files[0];

                        // Validate file type
                        const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
                        if (!validTypes.includes(file.type)) {
                            Toaster.warning('Invalid file type. Please select an image (PNG, WEBP, JPG)');
                            event.target.value = ''; // Clear the input
                            this.imagePreview = this.defaultImage; // Reset the preview
                            return;
                        }

                        // Validate file size (max 2 MB)
                        const maxSize = 2 * 1024 * 1024; // 2 MB
                        if (file.size > maxSize) {
                            Toaster.warning('File size exceeds 2 MB. Please select a smaller image.');
                            event.target.value = ''; // Clear the input
                            this.imagePreview = this.defaultImage; // Reset the preview
                            return;
                        }

                        // If valid, read the file and set the preview
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    },
                    handleDrop(event) {
                        this.dragging = false; // Reset dragging state
                        const files = event.dataTransfer.files;
                        if (files.length > 0) {
                            this.fileChosen({
                                target: {
                                    files
                                }
                            }); // Call fileChosen with dropped files
                        }
                    }
                };
            }
        </script>
    @endpush
