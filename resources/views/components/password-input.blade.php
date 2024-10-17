@props(['disabled' => false])

<div class="relative" x-data="{ showPassword: false }">
    <input autocomplete="new-password" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-11 font-medium text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary',
    ]) !!} :type="showPassword ? 'text' : 'password'">
    <span class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" @click="showPassword = !showPassword">
        <box-icon color="#888" name='show' x-show="!showPassword"></box-icon>
        <box-icon color="#888" name='hide' x-show="showPassword"></box-icon>
    </span>
</div>
