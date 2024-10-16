<div class="p-6">
    <form wire:submit="save" x-data="imagePreviewer">
        <div class="mb-4 flex items-center gap-3 justify-center">
            <div class="rounded-full">
                <img :src="imagePreview" class="w-30 h-30 rounded-full object-cover" src="" alt="user photo">
            </div>
            <div>
               
                <div id="FileUpload" @dragover.prevent @dragleave="dragging = false" @drop.prevent="handleDrop($event)"
                    class="relative mb-5.5 block w-full cursor-pointer appearance-none rounded border border-dashed border-primary bg-gray px-4 py-4 dark:bg-meta-4 sm:py-7.5">
                    <input @change="fileChosen($event)" type="file" wire:model="form.picture" id="picture" accept="image/jpeg, image/png, image/webp, image/jpg" 
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

        
       
        <div class="grid grid-cols-2 gap-4">
            <div class="">
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input placeholder="First name" wire:model="form.firstname" id="first_name" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.firstname')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input placeholder="Last name" wire:model="form.lastname" id="last_name" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.lastname')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input placeholder="Phone number" x-mask="(999) 9999-999" wire:model="form.phone_number" id="phone" class="mt-1 block w-full"
                    type="text" />
                <x-input-error :messages="$errors->get('form.phone_number')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input placeholder="Email" wire:model="form.email" id="email" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input placeholder="Password" wire:model="form.password" id="password" class="mt-1 block w-full" type="text" />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="confirm_password" :value="__('Confirm Password')" />
                <x-text-input placeholder="Confirm password" wire:model="form.confirm_password" id="confirm_password" class="mt-1 block w-full"
                    type="text" />
                <x-input-error :messages="$errors->get('form.confirm_password')" class="mt-2" />
            </div>
            <div class="">
                <div class="mt-3">
                    <x-input-label for="type" :value="__('User Type')" />
                    <x-select id="type" wire:model="form.type" :options="['Admin' => 'admin', 'Staff' => 'staff']" />
                    <x-input-error :messages="$errors->get('form.type')" class="mt-2" />
                </div>
            </div>

        </div>
        <div class="mt-5">
            <x-toggle-switch id="status-toggle" wire:model="form.status" :label="__('Status')" value="1"
                :checked="true" />
            <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
        </div>
        <div class="mt-5 flex">
            <x-secondary-button type="button" wire:click="$dispatch('closeModal')" class="ms-auto me-2">
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
    </form>
</div>

