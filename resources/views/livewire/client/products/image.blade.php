<form wire:submit.prevent="save">
    <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-show="showImageLibraryModal" x-cloak
        class="fixed inset-0 flex items-center justify-center z-[9999]">
        <div class="bg-gray-500 opacity-75 absolute inset-0"></div>
        <div class="bg-white rounded-lg shadow-lg max-w-6xl w-full p-6 z-50 relative">
            <input wire:model="images" wire:ignore class="1absolute w-full h-full top-0 start-0" multiple type="file"
                accept="image/jpeg, image/png, image/webp, image/jpg" />
            <div wire:loading class="absolute w-full h-full bg-slate-50/90 top-0 start-0 rounded z-50">
                <div class="flex w-full h-full items-center">
                    <div role="status" class="m-auto">
                        <svg aria-hidden="true"
                            class="w-12 h-12 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="mb-5 px-2">
                <div class="text-lg font-semibold">Image Library</div>
                <p x-text="imageVariation.variation_name"></p>
            </div>
            <div
                class="h-[75vh] overflow-y-auto px-2 [&::-webkit-scrollbar]:w-2
                [&::-webkit-scrollbar-track]:bg-gray-100
                [&::-webkit-scrollbar-thumb]:bg-gray-300
                dark:[&::-webkit-scrollbar-track]:bg-neutral-700
                dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                <div :class="images.length ? 'items-top' : 'items-center h-full'" class="flex flex-wrap -mx-2">
                    <template x-for="image in images">
                        <div class="w-1/2 sm:w-1/3 md:w-1/4 p-2">
                            <div @click="pushImage(image)"
                                class="cursor-pointer relative border border-1 rounded border-gray-100">
                                <img class="rounded h-40 object-cover w-full" :src="image.image_url" alt="">
                                <div @click.stop="" class="p-2 absolute bottom-0 start-0 z-100 w-full">
                                    <div class="flex items-center w-full">
                                        <select @change="setImageType(image, $event.target.value)" @click.prevent=""
                                            class="relative z-20 me-auto py-1 w-auto appearance-none rounded border border-stroke  outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                                            <option :selected="image.type == 'extra'" value="extra">Extra</option>
                                            <option :selected="image.type == 'thumbnail'" value="thumbnail">Thumbnail
                                            </option>
                                        </select>
                                        <x-action-button class="opacity-85"
                                            @click="confirmAction(image.id, 'destroy', 'Are you sure want to delete this image?')"
                                            x-data="{ tooltip: 'Delete' }" x-tooltip="tooltip" role="button">
                                            <box-icon size="20px" color="#888" name='trash'></box-icon>
                                        </x-action-button>
                                    </div>
                                </div>
                                <div x-show='selectedImages.some(el => el.id === image.id)'
                                    class="p-2 absolute top-0 end-0 opacity-85">
                                    <x-action-button>
                                        <box-icon color="#3c50e0" name='check'></box-icon>
                                    </x-action-button>
                                </div>
                            </div>
                        </div>
                    </template>
                    <div class="m-auto" x-show="!images.length">
                        No images found.
                    </div>
                </div>
            </div>
            <div class="px-2">
                <p class="text-sm">Drag and drop files in this area to upload</p>
            </div>
            <!-- Close Button -->
            <div class="mt-5 flex px-2">
                <label for="image_upload" role="button"
                    class="relative capitalize flex justify-center rounded bg-primary px-6 py-2 font-medium text-gray hover:bg-opacity-90 ms-auto me-2">
                    Upload images
                </label>
                <x-secondary-button type="button" @click="showImageLibraryModal = false" class="ms-2">
                    Close
                </x-secondary-button>
            </div>
        </div>

    </div>
</form>
