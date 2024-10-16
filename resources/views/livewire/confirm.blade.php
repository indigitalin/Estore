<div x-data="{ open: false, modelId: null, action: null, message: '' }"
    @open-modal.window="open = true; modelId = $event.detail.modelId; action = $event.detail.action; message = $event.detail.message"
    x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center z-[9999]">

    <div class="bg-gray-500 opacity-75 absolute inset-0" @click="open = false"></div>

    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 z-50">
        <div class="">
            <div class="text-xl font-semibold mb-5">Heads up!</div>
            <p x-text="message">Are you sure want to delete the role?</p>
            <div class="mt-5 flex">
                <x-secondary-button type="button" @click="open = false" class="ms-auto me-2">
                    No, cancel
                </x-secondary-button>
                <x-danger-button @click="actionConfirmed(modelId, action); open = false">
                    Yes, continue
                </x-danger-button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function confirmAction(modelId, action, message) {
            window.dispatchEvent(new CustomEvent('open-modal', {
                detail: {
                    modelId: modelId,
                    action: action,
                    message: message
                }
            }));
        }
        function actionConfirmed(modelId, action) {
            Livewire.dispatch(action, {
                id: modelId
            });
        }
    </script>
@endpush
