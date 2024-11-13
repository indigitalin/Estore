<div wire:ignore x-data="categoryComponent()" @click.away="show = false" class="relative">
    <div @click="show = !show"
        class="flex items-center cursor-pointer rounded border border-stroke py-3 pl-3 pr-3 text-black bg-gray focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 w-full">
        <div>
            <div x-show="id">
                <div class="flex items-center gap-3 cursor-pointer">
                    <div class="flex-shrink-0 ">
                        <img :src="image" class="w-8 h-8 object-cover rounded-full" alt="Brand" />
                    </div>
                    <div class="">
                        <p class="font-medium sm:block capitalize" x-text="name"></p>
                    </div>
                </div>
            </div>
            <div x-show="!id">
                Select an option
            </div>
        </div>
        <div class="ms-auto"><box-icon name='chevron-down' color="#888"></box-icon></div>
    </div>
    <div x-show="show" style="display:none"
        class="z-[100] absolute rounded border border-stroke text-black bg-white focus:border-primary focus-visible:outline-none dark:border-strokedark dark:bg-meta-4 dark:text-white dark:focus:border-primary mt-1 block w-full">
        <label for="category_id_0" class="block">
            <div @click="show = false; id = null; name=null; image=null; setCategoryId()"
                class="p-2 px-4 flex items-center gap-3 cursor-pointer">
                <div class="">
                    <p class="font-medium sm:block capitalize">
                        No category
                    </p>
                </div>
            </div>
            <input x-show="false" type="radio" hidden value="" name="category_id" id="category_id_0">
        </label>
        <template x-for="category in categories">
            <div>
                <template x-template-outlet="$refs.treeNodeTemplate" x-data="{ category: category, parentCategory: null }">
                </template>
            </div>
        </template>
        <template x-ref="treeNodeTemplate">
            <div>
                <label :for="category.childs.length ? '' : 'category_id_' + category.id" class="block"
                    :class="'category-item parent-' + category.parent_handle">
                    <div :class="category.childs.length ? 'hover:bg-gray-100' :
                        'hover:bg-gray-200'"
                        @click="categorySelected(category, true)" class="flex items-center gap-3 cursor-pointer">
                        <label :for="'category_id_' + category.id" @click.stop="categorySelected(category)"
                            class="block cursor-pointer">
                            <div :class="category.childs.length ? 'hover:bg-gray-200' : ''"
                                class="p-2 px-4 rounded gap-3 flex items-center">
                                <div class="flex-shrink-0 ">
                                    <img :src="category.picture_url" class="w-10 h-10 object-cover rounded-full"
                                        alt="Brand" />
                                </div>
                                <div class="">
                                    <p x-text="category.name" class="font-medium sm:block capitalize">
                                    </p>
                                </div>
                            </div>
                        </label>
                        <div class="flex items-center ms-auto px-4" x-show="category.childs.length">
                            <box-icon color="#888" name='chevron-right'></box-icon>
                        </div>
                    </div>
                    <input x-show="false" type="radio" hidden :value="category.id" name="category_id"
                        wire:form="form.category_id" :id="'category_id_' + category.id">
                </label>
                <div x-show="category.childs.length">
                    <div x-show="category.showChilds">
                        <label @click="hideChildCategories(category)"
                            :class="'category-item parent-' + category.handle">
                            <div class="p-2 px-4 flex items-center gap-3 cursor-pointer">
                                <box-icon color="#888" name='left-arrow-alt'></box-icon>
                                <div class="" x-text="category.parent_name">
                                </div>
                            </div>
                        </label>
                        <template x-for="childNode in category.childs" :key="childNode.id">
                            <div>
                                <template x-template-outlet="$refs.treeNodeTemplate" x-data="{ category: childNode, parentCategory: category }">
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
        <div x-init="preloadCategory()"></div>
    </div>
</div>
@push('scripts')
    <script>
        function categoryComponent() {
            return {
                categories: @js($categories),
                category_id: {{ $this->form->category_id ?? 0 }},
                show: false,
                id: 0,
                image: null,
                name: null,
                selectedCategoryParentTrees:[],
                init(){
                    //this.preloadCategory()
                },
                categorySelected(category, subCategorySelection = false) {
                    if (subCategorySelection && category.childs.length) {
                        this.showChildCategories(category);
                    } else {
                        this.show = false;
                        this.id = category.id;
                        this.category_id = this.id;
                        this.name = category.name;
                        this.image = category.picture_url;
                        this.setCategoryTree(category);
                        //this.preloadCategory();
                    }
                    this.setCategoryId();
                },
                showChildCategories(category) {
                    document.querySelectorAll("label.category-item").forEach(el => {
                        el.style.display = "none";
                    });

                    document.querySelectorAll("label.category-item.parent-" + category.handle).forEach(el => {
                        el.style.display = "block";
                    });
                    category.showChilds = true;
                },
                hideChildCategories(category) {
                    document.querySelectorAll("label.category-item.parent-" + category.parent_handle).forEach(el => {
                        el.style.display = "block";
                    });
                    category.showChilds = false;
                },
                preloadCategory() {
                    const category = this.findCategory(this.categories, this.category_id);
                    if (category) {
                        this.categorySelected(category);
                    }
                    
                },
                async setCategoryTree(category){
                    this.selectedCategoryParentTrees = [];
                    await this.findParentTree(category);
                    this.selectedCategoryParentTrees.reverse();
                    for (const category of this.selectedCategoryParentTrees) {
                        this.showChildCategories(category);
                    }
                },
                findParentTree(category){
                    const parent = this.findCategory(this.categories, category.parent_id);
                    if(parent){
                        this.selectedCategoryParentTrees.push(parent);
                        if(parent.parent_id){
                            return this.findParentTree(parent);
                        }
                    }
                    return this.selectedCategoryParentTrees;
                },
                setCategoryId() {
                    Livewire.dispatch('set-category', {
                        category: this.id
                    });
                },
                findCategory(categories, id) {
                    let foundItem;
                    for (const category of categories) {
                        // Check if the current category matches the ID
                        if (category.id === id) {
                            foundItem = category;
                            break;
                        }
                        // If the category has children, recursively search them
                        if (category.childs && category.childs.length > 0) {
                            const found = this.findCategory(category.childs, id);
                            if (found) {
                                foundItem = found;
                                break;
                                //return found;
                            }
                        }
                    }
                    // Return null if not found
                    return foundItem;
                }
            }
        }
    </script>
@endpush
