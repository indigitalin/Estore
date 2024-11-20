<div x-data="imageLibrary" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" x-show="showImageLibraryModal" x-cloak
    class="fixed inset-0 flex items-center justify-center z-[9999]">

    <div class="bg-gray-500 opacity-75 absolute inset-0"></div>

    <div class="bg-white rounded-lg shadow-lg max-w-6xl w-full p-6 z-50">
        <div class="text-lg font-semibold mb-5 px-2">Image Library</div>

        <div
            class="h-[75vh] overflow-y-auto px-2 [&::-webkit-scrollbar]:w-2
  [&::-webkit-scrollbar-track]:bg-gray-100
  [&::-webkit-scrollbar-thumb]:bg-gray-300
  dark:[&::-webkit-scrollbar-track]:bg-neutral-700
  dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
            <div :class="attachments.length ? 'items-top' : 'items-center h-full'" class="flex flex-wrap -mx-2">
                <template x-for="attachment in attachments">
                    <div class="w-full sm:w-1/3 md:w-1/6 p-2">
                        <div class="cursor-pointer relative">
                            <img class="rounded h-36 object-cover w-full" :src="attachment.file_url" alt="">
                            <div class="absolute w-full h-full z-100 top-0 start-0 opacity-0 hover:opacity-100">
                                <div class="w-full h-full relative">
                                    <div class="p-2 absolute bottom-0 end-0 opacity-85">
                                        <x-action-button
                                            @click="confirmAction(attachment.id, 'destroy', 'Are you sure want to delete this attachment?')"
                                            x-data="{ tooltip: 'Delete' }" x-tooltip="tooltip" role="button">
                                            <box-icon size="20px" color="#888" name='trash'></box-icon>
                                        </x-action-button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <div class="m-auto" x-show="!attachments.length">
                    No attachments found.
                </div>
            </div>
        </div>
        <div>
            <p class="text-sm">Drag and drop files in this area to upload</p>
        </div>
        <!-- Close Button -->
        <div class="mt-5 flex">
            <x-primary-button type="button" class="ms-auto me-2">
                Upload
                </x-secondary-button>
                <x-secondary-button type="button" @click="showImageLibraryModal = false" class="ms-2">
                    Close
                </x-secondary-button>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function imageLibrary() {
            return {
                showImageLibraryModal: true,
                multiple: true,
                attachments: @json($attachments),
                init() {
                    window.addEventListener('attachmentDeleted', (event) => {
                        console.log(event);
                        this.attachments = this.attachments.filter(
                            (attachment) => attachment.id !==  event.detail[0].attachment_id
                        );
                    });
                },
            }
        }
    </script>
@endpush
