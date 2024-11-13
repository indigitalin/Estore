<div x-data="tagComponent()">
    <div class="relative">
        <x-text-input x-model="name" @keydown.enter.prevent="enterProductTag()" @change="enterProductTag()" autocomplete="off"
            placeholder="Product tags" id="type" class="mt-1 block w-full" type="text" />
    </div>
    <div class="text-sm">Press enter to set entered tags</div>
    <div class="mt-2">
        <div class="flex items-center flex-wrap gap-1">
            <template x-for="tag in tags">
                <div class="bg-indigo-200 p-2 py-1 rounded flex items-center gap-2">
                    <div x-text="tag"></div>
                    <box-icon color="#888" @click="removeProductTag(tag)" name='x-circle'
                        class="cursor-pointer"></box-icon>
                </div>
            </template>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function tagComponent() {
            return {
                show: false,
                tags: @entangle('form.product_tags'),
                name: null,
                enterProductTag() {
                    if (this.name && this.name.trim().length > 0) { // Check if name is not empty or whitespace
                        this.tags = [...new Set([...this.tags, this.name])];
                        this.name = null;
                    } else {
                        Toaster.warning('Please enter valid tags.')
                    }
                    this.setProductTag();
                },
                setProductTag() {
                    Livewire.dispatch('set-product-tags', {
                        product_tags: this.tags
                    });
                },
                removeProductTag(tag) {
                    this.tags = this.tags.filter(element => element !== tag);
                    this.setProductTag();
                }
            }
        }
    </script>
@endpush
