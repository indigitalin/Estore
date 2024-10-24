<div class="">
    @php
        $pageTitle = $plan ? 'Edit Plan' : 'Create Plan';
        $navigationLinks = [
            ['text' => 'Dashboard', 'link' => route('admin.index')],
            ['text' => 'Subscription Plans', 'link' => route('admin.subscriptions.index')],
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
            <div class="grid grid-cols-1 gap-8">
                <div class="col-span-5 xl:col-span-3">
                    <div class="rounded-sm border border-stroke bg-white dark:border-strokedark dark:bg-boxdark">
                        <div class="border-b border-stroke px-7 py-4 dark:border-strokedark">
                            <h3 class="font-medium text-black dark:text-white">
                                Plan information
                            </h3>
                        </div>

                        <div class="p-7 pt-0">
                            <div class="flex flex-wrap -mx-2">
                                <div class="w-full  p-2">
                                    <div class="mt-2">
                                        <x-input-label for="name" :value="__('Name')" />
                                        <x-text-input placeholder="Name" wire:model="form.name" id="name"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.name')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="w-full p-2">
                                    <div class="mt-2">
                                        <x-input-label for="description" :value="__('Description')" />
                                        <x-textarea placeholder="Description" wire:model="form.description"
                                            id="description" class="mt-1 block w-full" />
                                        <x-input-error :messages="$errors->get('form.description')" class="mt-2" />
                                    </div>
                                </div>



                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="amount" :value="__('Amount')" />
                                        <x-text-input placeholder="Amount" wire:model="form.amount" id="amount"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.amount')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full md:w-1/2 p-2">
                                    <div class="mt-2">
                                        <x-input-label for="validity" :value="__('Validity')" />
                                        <x-text-input placeholder="Validity" wire:model="form.validity" id="validity"
                                            class="mt-1 block w-full" type="text" />
                                        <x-input-error :messages="$errors->get('form.validity')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="w-full mt-4 border-b-2 p-2">
                                    <x-input-label :value="__('Modules')" />
                                    <div class="flex flex-wrap -mx-2 gap-5">
                                        @foreach ($modules as $section => $items)
                                            <div class="w-full md:w-1/4 p-2">
                                                <x-toggle-switch wire:model="form.modules"
                                                    label="{{ $items->name }}" checked=""
                                                    value="{{ $items->id }}"
                                                    id="modules_{{ $items->id }}" />
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class=" w-full p-2 gap-5 -mx-2 p-2">
                                    <div class="mt-5 p-2">
                                        <x-toggle-switch id="popular-toggle" wire:model="form.popular" :label="__('Popular')"
                                            :value="1" :checked="$plan && $plan->popular == '1' ? true : false" />
                                        <x-input-error :messages="$errors->get('form.popular')" class="mt-2" />
                                    </div>
                                    <div class="mt-5 p-2">
                                        <x-toggle-switch id="status-toggle" wire:model="form.status" :label="__('Status')"
                                            :value="1" :checked="$plan && $plan->status == '1' ? true : false" />
                                        <x-input-error :messages="$errors->get('form.status')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                          
                            
                            <div class="mt-5 flex">
                                <x-secondary-button wire:navigate href="{{ route('admin.subscriptions.index') }}"
                                    class="ms-auto me-2">
                                    Cancel
                                </x-secondary-button>
                                <x-primary-button>
                                    @if ($this->plan)
                                        Update Plan
                                    @else
                                        Create Plan
                                    @endif
                                </x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

