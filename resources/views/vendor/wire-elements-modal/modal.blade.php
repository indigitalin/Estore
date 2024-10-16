<div>
    @isset($jsPath)
        <script>{!! file_get_contents($jsPath) !!}</script>
    @endisset
    @isset($cssPath)
        <style>{!! file_get_contents($cssPath) !!}</style>
    @endisset


    @props([
        'modalTitle' => '',
        'maxWidth' => '2xl'
    ])
    
 

    @php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        'w-full' => 'w-full  max-h-full'
    ][$maxWidth];
    @endphp

    

    <div
            x-data="LivewireUIModal()"
            x-on:close.stop="setShowPropertyTo(false)"
            x-on:keydown.escape.window="closeModalOnEscape()"
            x-show="show"
            class="fixed inset-0 z-[9999] overflow-y-auto"
            style="display: none;"
    >
        <div class="relative">
            <div class="flex w-full mb-7 fixed bg-white z-[9999]">
                <div class="w-1/2 text-2xl dark:text-white">
                    {{ $ModalTitle }}
                </div>
            
                <div class="w-1/2 text-right">
                    <button
                        class="font-bold hover:bg-gray-100 dark:bg-gray-800 hover:dark:bg-gray-900 dark:text-white px-3 py-1.5 rounded"
                        title="Close"
                        tabindex="0"
                        onclick="Livewire.dispatch('closeModal')"
                    >
                        X
                    </button>
                </div>
            </div>
    </div>
    
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-10 text-center sm:block sm:p-0">
            <div
                    x-show="show"
                    x-on:click="closeModalOnClickAway()"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-all transform"
            >
                <div class="absolute inset-0 bg-white"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div
        x-show="show && showActiveComponent"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-bind:class="modalWidth"
        class="inline-block w-full align-bottom bg-white rounded-lg text-left overflow-hidden  transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto sm:align-middle"
        id="modal-container"
        x-trap.noscroll.inert="show && showActiveComponent"
        aria-modal="true"
>

                @forelse($components as $id => $component)
                    <div x-show.immediate="activeComponent == '{{ $id }}'" x-ref="{{ $id }}" wire:key="{{ $id }}">
                        @livewire($component['name'], $component['arguments'], key($id))
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>
