<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');
        \Toaster::success(__($status));
    }
}; ?>



<div class="mt-6 px-6 py-10 bg-white dark:bg-gray-800 shadow-sm overflow-hidden sm:rounded-lg">

    <!-- ===== Content Area Start ===== -->
    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

        <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

            <!-- ====== Forms Section Start -->
            <div class="rounded-sm bg-white dark:border-strokedark dark:bg-boxdark">
                <div class="flex flex-wrap items-center">
                    <div class="hidden w-full xl:block xl:w-1/2">
                        <div class="py-17.5 text-center">
                            <div class="px-26 ">
                                <a class="mb-5.5 inline-block" href="index.html">
                                    <img class="hidden dark:block" src="src/images/e-store.png" alt="Logo" />
                                    <img class="dark:hidden" src="src/images/logo/e-store.png" alt="Logo" />
                                </a>
                            </div>
                            <div class="text-xl">Recover your account</div>
                            <p class="font-medium 2xl:px-20">
                                {{ __('Forgot your password? No problem. You can reset') }}
                            </p>

                            <div class="px-26">
                                <span class="mt-15 inline-block">
                                    <img src="src/images/illustration/illustration-03.svg" alt="illustration" />
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="w-full border-stroke dark:border-strokedark xl:w-1/2 xl:border-l-2">
                        <div class="w-full p-4 sm:p-12.5 xl:p-17.5">
                            <span class="mb-1.5 block font-medium">Easy to forget</span>
                            <h2 class="mb-9 text-2xl font-bold text-black dark:text-white sm:text-title-xl2">
                                Forgot your password
                            </h2>
                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form wire:submit="sendPasswordResetLink">
                                <!-- Email Address -->
                                <div class="mb-6">
                                    <x-input-label class="mb-2.5 block font-medium text-black dark:text-white"
                                        for="email" :value="__('Email')" />
                                    <div class="relative">

                                        <x-text-input placeholder="Enter your email" wire:model="email" id="email" class="block mt-1 w-full"
                                            type="email" name="email" required autofocus />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />

                                        <span class="absolute right-4 top-4">
                                            <svg class="fill-current" width="22" height="22" viewBox="0 0 22 22"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g opacity="0.5">
                                                    <path
                                                        d="M19.2516 3.30005H2.75156C1.58281 3.30005 0.585938 4.26255 0.585938 5.46567V16.6032C0.585938 17.7719 1.54844 18.7688 2.75156 18.7688H19.2516C20.4203 18.7688 21.4172 17.8063 21.4172 16.6032V5.4313C21.4172 4.26255 20.4203 3.30005 19.2516 3.30005ZM19.2516 4.84692C19.2859 4.84692 19.3203 4.84692 19.3547 4.84692L11.0016 10.2094L2.64844 4.84692C2.68281 4.84692 2.71719 4.84692 2.75156 4.84692H19.2516ZM19.2516 17.1532H2.75156C2.40781 17.1532 2.13281 16.8782 2.13281 16.5344V6.35942L10.1766 11.5157C10.4172 11.6875 10.6922 11.7563 10.9672 11.7563C11.2422 11.7563 11.5172 11.6875 11.7578 11.5157L19.8016 6.35942V16.5688C19.8703 16.9125 19.5953 17.1532 19.2516 17.1532Z"
                                                        fill="" />
                                                </g>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button
                                        class="w-full cursor-pointer rounded-lg border border-primary bg-primary p-4 font-medium text-white transition hover:bg-opacity-90">
                                        {{ __('Email Password Reset Link') }}
                                    </x-primary-button>

                                </div>
                            </form>
                            <div class="mt-6 text-center mt-5">
                                <p class="font-medium">
                                    Back to login page
                                    <a wire:navigate href="{{ url('login') }}" class="text-primary">Login</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
