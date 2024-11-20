<div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    x-show="showImageLibraryModal" x-cloak class="fixed inset-0 flex items-center justify-center z-[9999]">

    <div class="bg-gray-500 opacity-75 absolute inset-0"></div>

    <div class="bg-white rounded-lg shadow-lg max-w-6xl w-full p-6 z-50">
        <div class="text-lg font-semibold mb-5 px-2">Image Library</div>

        <div
            class="max-h-[80vh] overflow-y-auto px-2 [&::-webkit-scrollbar]:w-2
  [&::-webkit-scrollbar-track]:bg-gray-100
  [&::-webkit-scrollbar-thumb]:bg-gray-300
  dark:[&::-webkit-scrollbar-track]:bg-neutral-700
  dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
        
        </div>

        <!-- Close Button -->
        <div class="mt-5 flex">
            <x-secondary-button type="button" @click="showImageLibraryModal = false" class="ms-auto me-2">
                Close
            </x-secondary-button>
        </div>
    </div>
</div>
