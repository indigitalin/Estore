@props(['disabled' => false])

<textarea {{ $attributes['type'] == 'password' ? 'autocomplete=new-password' : 'autocomplete=off' }}  {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full rounded border border-stroke bg-gray py-3 pl-11.5 pr-4.5 font-medium text-black focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary']) !!}></textarea>
