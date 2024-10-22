{{-- 
<div x-data="{ switcherToggle: {{ $checked ? true :false }} }">
    <label
      for="{{ $id }}"
      class="flex cursor-pointer select-none items-center"
    >
      <div class="relative">
        <input
          type="checkbox"
          {!! $attributes !!} value="{{ $value }}"
          id="{{ $id }}"
          class="sr-only"
          {{ $checked ? 'checked' : '' }}
          @change.prevent="switcherToggle = !switcherToggle"
        />
        <div
          class="block h-8 w-14 rounded-full bg-meta-9 dark:bg-[#5A616B]"
        ></div>
        <div
          :class="switcherToggle && '!right-1 !translate-x-full !bg-primary dark:!bg-white'"
          class="dot absolute left-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-white transition"
        >
          <span
            :class="switcherToggle && '!block'"
            class="hidden text-white dark:text-bodydark"
          >
          <box-icon name='check'></box-icon>
          </span>
          <box-icon name='x' ></box-icon>
        </div>
      </div>
    </label>
  </div> --}}


  <label for="{{ $id }}" class="inline-flex relative items-center cursor-pointer">
    <input type="checkbox" {!! $attributes !!} value="{{ $value }}" id="{{ $id }}" class="sr-only peer" {{ $checked ? 'checked' : '' }}>
    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $label }}</span>
</label> 

