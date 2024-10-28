<div class="">
    @php
        $pageTitle = $user ? 'Edit User' : 'Create User';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => roleRoute('{role}.index')],
            ['text' => 'Users', 'link' => roleRoute('{role}.users.index')],
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
            <div class="grid grid-cols-6 gap-8">
                <div class="col-span-6 xl:col-span-4">
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
                                        <x-text-input :disabled="$user" placeholder="Email" wire:model="form.email"
                                            id="email" class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                                        @if($user)
                                        <p class="text-sm mt-2 mb-2 flex items-center text-gray-500"> <box-icon
                                            color="#777" size="16px" name='error-circle'
                                            class="me-1"></box-icon> Email can
                                        not be changed. This user have to login to change their email.</p>
                                        </p>
                                        <div  class="text-indigo-600 cursor-pointer" @click="confirmAction({{ $user->id }}, 'sendPasswordResetLink', 'Are you sure want to send password reset link?')">Send password reset link</div>
                                        @endif
                                    </div>
                                </div>
                                @if (!$this->user)
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
                                <x-secondary-button wire:navigate href="{{ roleRoute('{role}.users.index') }}"
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
                <div class="col-span-6 xl:col-span-2">
                    <div class="rounded-sm border border-stroke bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Profile photo
                            </h3>
                        </div>
                        <div class="p-7 pt-0 mt-4">
                            <div>
                                <x-image-upload :default="$user->default_picture_url ?? asset('/default.png')" :uploaded="$user->picture_url ?? asset('/default.png')" :name="'form.picture'"></x-image-upload>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<x-form-error :error="$errors" />