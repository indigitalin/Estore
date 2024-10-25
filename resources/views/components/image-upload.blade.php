@props(['name', 'uploaded', 'default'])
<div>
    <div x-data="imagePreviewer('{{ $uploaded }}', '{{ $default }}')">
        <input hidden @change="fileChosen($event)" type="file" name="{{ $name }}"
            wire:model="{{ $name }}" id="{{ $name }}"
            accept="image/jpeg, image/png, image/webp, image/jpg" />
        <input hidden wire:model="{{ $name }}_removed">
        <div class="w-full cursor-pointer relative" @dragover.prevent @dragleave="dragging = false"
            @drop.prevent="handleDrop($event)">
            <img class="w-full h-60 object-cover" :src="imagePreview" alt="">
            <label class="block" for="{{ $name }}">
                <div
                    class="text-center cursor-pointer bg-gray-700/20 absolute start-0 top-0 w-full h-full flex items-center">
                    <div class="m-auto text-center text-white">
                        <div class="">Upload {{ $name }}</div>
                        <box-icon name='upload' color="#fff"></box-icon>
                    </div>
                </div>
            </label>
            <div x-show="selected" class="absolute bottom-0 end-0 p-2 z-50">
                <div @click="removeImage(); $wire.set('{{ $name }}_removed', '1')"
                    class="flex items-center justify-center w-9 h-9 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg toggle-full-view hover:bg-gray-100 hover:text-indigo-700 focus:z-10 focus:ring-2 focus:ring-gray-300 dark:focus:ring-gray-500 dark:bg-gray-800 focus:outline-none dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    <box-icon name='trash'></box-icon>
                </div>
            </div>
        </div>
        <div class="text-sm text-gray-800">Allowed images. PNG, JPG, WEBP (max 2mb)</div>
        <x-input-error :messages="$errors->get($name)" class="mt-2" />
    </div>
</div>

@push('scripts')
    @if (!isset($imagePreviewerScriptLoaded))
        @php
            $imagePreviewerScriptLoaded = true;
        @endphp
        <script>
            function imagePreviewer(uploadedImage, defaultImage) {
                return {
                    imagePreview: uploadedImage, // Initial preview URL from backend
                    dragging: false, // State for drag events
                    uploadedImage: uploadedImage,
                    defaultImage: defaultImage,
                    selected: defaultImage != uploadedImage,
                    removed: false,
                    removeImage() {
                        this.selected = false; // Reset selected state
                        this.imagePreview = this.defaultImage; // Reset preview image
                    },
                    fileChosen(event) {
                        const file = event.target.files[0];

                        // Validate file type
                        const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
                        if (!validTypes.includes(file.type)) {
                            Toaster.warning('Invalid file type. Please select an image (PNG, WEBP, JPG)');
                            event.target.value = ''; // Clear the input
                            this.imagePreview = this.uploadedImage; // Reset the preview
                            return;
                        }

                        // Validate file size (max 2 MB)
                        const maxSize = 2 * 1024 * 1024; // 2 MB
                        if (file.size > maxSize) {
                            Toaster.warning('File size exceeds 2 MB. Please select a smaller image.');
                            event.target.value = ''; // Clear the input
                            this.imagePreview = this.uploadedImage; // Reset the preview
                            return;
                        }

                        // If valid, read the file and set the preview
                        const reader = new FileReader();
                        this.selected = true; // Mark as selected
                        reader.onload = (e) => {
                            this.imagePreview = e.target.result; // Set the image preview
                        };
                        reader.readAsDataURL(file);
                    },
                    handleDrop(event) {
                        this.dragging = false; // Reset dragging state
                        const files = event.dataTransfer.files;
                        if (files.length > 0) {
                            this.fileChosen({
                                target: {
                                    files
                                }
                            }); // Call fileChosen with dropped files
                        }
                    }
                };
            }
        </script>
    @endif
@endpush
