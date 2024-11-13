<div wire:ignore x-data="collectionComponent()" @click.away="show = false" class="relative">
    <div @click="show = !show"
        class="flex items-center cursor-pointer rounded border border-stroke py-3 pl-3 pr-3 text-black bg-gray focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 w-full">
        <div>
            <div>
                Select options
            </div>
        </div>
        <div class="ms-auto"><box-icon name='chevron-down' color="#888"></box-icon></div>
    </div>
    <div x-show="show" style="display:none"
        class="z-[100] absolute rounded border border-stroke text-black bg-white focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 block w-full">

        <template x-for="collection in collections">
            <label :for="'collections_'+collection.id" class="block">
                <div @click="show = false; setCollection(collection)"
                    class="p-2 px-4 flex items-center gap-3 cursor-pointer" :class="selectedCollectionIds.includes(collection.id) ? 'bg-indigo-200' : 'hover:bg-gray-100'">
                    <div class="">
                        <p class="font-medium sm:block capitalize" x-text="collection.name"></p>
                    </div>
                </div>
                <input x-show="false" type="radio" hidden :value="collection.id" name="collections" x-bind:wire:model="'form.collections.'+collection.id" :id="'collections_'+collection.id">
            </label>
        </template>
        <div x-init="loadSelectedCategories()"></div>
    </div>
    <div class="mt-2">
        <div class="flex items-center flex-wrap gap-1">
            <template x-for="selectedCollection in selectedCollections">
                <div class="bg-indigo-200 p-2 py-1 rounded flex items-center gap-2">
                    <div x-text="selectedCollection.name"></div>
                    <box-icon color="#888" @click="removeCollection(selectedCollection)" name='x-circle' class="cursor-pointer"></box-icon>
                </div>
            </template>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function collectionComponent() {
            return {
                collections: @js($collections),
                show: false,
                selectedCollections: [],
                selectedCollectionIds:@js($this->form->collections),
                async removeCollection(collection){
                    this.selectedCollectionIds = await this.selectedCollectionIds.filter(element => element !== collection.id);
                    this.loadSelectedCategories();    
                },
                setCollection(collection){
                    if(this.selectedCollectionIds.includes(collection.id)){
                        this.removeCollection(collection);
                    }else{
                        this.selectedCollectionIds = [...new Set([...this.selectedCollectionIds, collection.id])];
                    }
                    this.loadSelectedCategories();    
                },
                loadSelectedCategories(){
                    this.selectedCollections = [];
                    for (const collectionId of this.selectedCollectionIds) {
                        const collection = this.collections.find(obj => obj.id === collectionId);
                        this.selectedCollections.push(collection);
                    }
                    Livewire.dispatch('set-collections', {
                        collections: this.selectedCollectionIds
                    });
                }
            }
        }
    </script>
@endpush
