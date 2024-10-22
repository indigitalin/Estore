<div class="">
    @php
        $pageTitle = $user ? 'Edit user' : 'Create user';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => route('admin.index')],
            ['text' => 'Users', 'link' => route('admin.users.index')],
            ['text' => $pageTitle, 'link' => ''],
        ];
        $pageDescription = '';
        $rightSideBtnText = '';
        $rightSideBtnRoute = '';
    @endphp
    <x-admin-breadcrumb :pageTitle=$pageTitle :navigationLinks=$navigationLinks :pageDescription=$pageDescription
        :rightSideBtnText=$rightSideBtnText :rightSideBtnRoute=$rightSideBtnRoute />

    <div class="">
        <form wire:submit.prevent="save" x-data="imagePreviewer('{{ $user ? $user->picture_url : asset('/default.png') }}')">
            <div class="grid grid-cols-5 gap-8">
                <div class="col-span-5 xl:col-span-3">
                    <div class="rounded-sm border border-stroke bg-white dark:border-strokedark dark:bg-boxdark">
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
                                        <x-text-input placeholder="Email" wire:model="form.email" id="email"
                                            class="mt-1 block w-full" type="text" />
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
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="phone" :value="__('Phone')" />
                                        <x-text-input placeholder="Phone number" x-mask="99999 99999"
                                            wire:model="form.phone_number" id="phone" class="mt-1 block w-full"
                                            type="text" />
                                        <x-input-error :messages="$errors->get('form.phone')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="role" :value="__('User Role')" />
                                        <x-select id="role" wire:model="form.role" :options="$roles"
                                            :selected="$user ? $user->role : null" />
                                        <x-input-error :messages="$errors->get('form.role')" class="mt-2" />
                                    </div>
                                </div>

                            </div>

                            <div class="mt-5">
                                <x-toggle-switch id="status-toggle" wire:model="form.status" :label="__('Status')"
                                    :value="1" :checked="$user && $user->status == '1' ? true : false" />
                                <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                            </div>
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate href="{{ route('admin.users.index') }}"
                                    class="ms-auto me-2">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button>
                                    @if ($this->user)
                                        Update user
                                    @else
                                        Create user
                                    @endif
                                </x-primary-button>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-span-5 xl:col-span-2">
                    <div class="rounded-sm border border-stroke bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Profile photo
                            </h3>
                        </div>
                        <div class="mb-4 flex flex-col items-center gap-3 justify-center">
                            <div class="rounded-full my-3">
                                <img :src="imagePreview" class="h-15 w-15 rounded-full object-cover" src=""
                                    alt="user photo">
                            </div>
                            <div>

                                <div id="FileUpload" @dragover.prevent @dragleave="dragging = false"
                                    @drop.prevent="handleDrop($event)"
                                    class="relative mb-5.5 block w-full cursor-pointer appearance-none rounded border border-dashed border-primary bg-gray px-4 py-4 dark:bg-meta-4 sm:py-7.5">
                                    <input @change="fileChosen($event)" type="file" wire:model="form.picture"
                                        id="picture" accept="image/jpeg, image/png, image/webp, image/jpg"
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
