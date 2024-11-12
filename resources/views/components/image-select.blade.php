@props(['name', 'options' => [], 'selected' => null])
@php
    $selected = $options->firstWhere('value', $selected);
@endphp
<div x-data="{ title: '{{ $selected['label'] ?? '' }}', image: '{{ file_url($selected['image'] ?? 'default.png') }}', show: false, id: {{ $selected['value'] ?? 0 }} }" @click.away="show = false" class="relative">
    <div @click="show = !show"
        class="flex items-center cursor-pointer rounded border border-stroke py-3 pl-3 pr-3 text-black bg-gray focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 w-full">
        <div>
            <div x-show="id !=0">
                <div class="flex items-center gap-3 cursor-pointer">
                    <div class="flex-shrink-0 ">
                        <img :src="image" class="w-8 h-8 object-cover rounded-full"
                            alt="Brand" />
                    </div>
                    <div class="">
                        <p class="font-medium sm:block capitalize" x-text="title"></p>
                    </div>
                </div>
            </div>
            <div x-show="id ==0">
                Select an option
            </div>
        </div>
        <div class="ms-auto"><box-icon name='chevron-down' color="#888"></box-icon></div>
    </div>
    <div x-show="show" style="display:none"
        class="z-[100] absolute rounded border border-stroke text-black bg-white focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 block w-full">
        <label for="{{ $name }}_0" class="block">
            <div @click="show = false; id = 0; title='';image=''" class="p-2 px-4 flex items-center gap-3 cursor-pointer">
                <div class="flex-shrink-0 ">
                    <img src="{{ file_url('default.png') }}" class="w-10 h-10 object-cover rounded-full"
                        alt="Brand" />
                </div>
                <div class="">
                    <p class="font-medium sm:block capitalize">
                        No image
                    </p>
                </div>
            </div>
            <input x-show="false" type="radio" hidden value=""
                wire:model="form.{{ $name }}" name="{{ $name }}"
                id="{{ $name }}_0">
        </label>
        @foreach ($options as $option)
            <label for="{{ $name }}_{{ $option['value'] }}" class="block"
                :class="id === {{ $option['value'] }} ? 'bg-indigo-200' : 'hover:bg-gray-100'">
                <div @click="show = false; id = {{ $option['value'] }};title='{{ $option['label'] }}';image='{{ file_url($option['image']) }}'"
                    class="p-2 px-4 flex items-center gap-3 cursor-pointer">
                    <div class="flex-shrink-0 ">
                        <img src="{{ file_url($option['image']) }}"
                            class="w-10 h-10 object-cover rounded-full" alt="Brand" />
                    </div>
                    <div class="">
                        <p class="font-medium sm:block capitalize">
                            {{ $option['label'] }}
                        </p>
                    </div>
                </div>
                <input x-show="false" type="radio" hidden value="{{ $option['value'] }}"
                    wire:model="form.{{ $name }}" name="{{ $name }}"
                    id="{{ $name }}_{{ $option['value'] }}">
            </label>
        @endforeach
    </div>
</div>
