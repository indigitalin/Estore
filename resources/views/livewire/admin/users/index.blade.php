<div class="">
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Users
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <a class="font-medium" href="index.html">Dashboard /</a>
                </li>
                <li class="font-medium text-primary">Users</li>
            </ol>
        </nav>
    </div>
    <div class="">
        <p>Manage your staff members easily. Search, view, and edit staff information.</p>
    </div>
    <div class="flex">
        <x-primary-button wire:click="$dispatch('openModal', { component: 'admin.users.user-modal-component'})"  class="mb-4 ms-auto">
            Create new user
        </x-primary-button>
    </div>
    <div
        class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">
                            User
                        </th>
                        <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Contact
                        </th>

                        <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Created at
                        </th>
                        <th class="min-w-[150px] px-4 py-4 font-medium text-black dark:text-white">
                            Last login
                        </th>

                        <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">
                            Status
                        </th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($users as $user)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 pl-5 dark:border-strokedark">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 ">
                                        <img src="{{ $user->picture_url }}"
                                            class="rounded-full w-15" alt="Brand" />
                                    </div>
                                    <div class="">
                                        <p class="hidden font-medium text-black dark:text-white sm:block">
                                            {{ $user->name }}
                                        </p>
                                        <i class="text-black dark:text-white text-sm capitalize">{{ $user->type }}</i>
                                    </div>
                                    
                                </div>
                            </td>

                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex flex-col">
                                    <a href="mailto:{{ $user->email }}"><i class="text-black dark:text-white">{{ $user->email }}</i></a>   
                                    <a href="tel:{{ $user->phoneNumber }}"><i class="text-black dark:text-white">{{ $user->phoneNumber }}</i></a>
                                </div>
                            </td>
                           
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <i class="text-black dark:text-white">{{ $user->created_at }}</i>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <i class="text-black dark:text-white">{{ $user->last_login }}</i>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                              
                                <p
                                    class="inline-flex rounded-full bg-success bg-opacity-10 px-3 py-1 text-sm font-medium text-success">
                                    {{ $user->status_label }}
                                </p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center space-x-3.5"> 
                                    <button class="hover:text-primary" wire:click="$dispatch('openModal', { component: 'admin.users.user-modal-component', arguments: { user: {{ $user }} }})">
                                        <box-icon name='pencil' size="sm" color="gray"></box-icon>
                                    </button>
                                    <button class="hover:text-primary">
                                        <box-icon name='show'   size="sm" color="gray"></box-icon>
                                    </button>
                                    <button class="hover:text-primary">
                                        <box-icon name='trash'   size="sm" color="gray"></box-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            {{ $users->links() }}
        </div>
    </div>

    <!-- ====== Table Three End -->
</div>



@push('scripts')
<script>
    function imagePreviewer() {
        return {
            imagePreview: '3232', // Initial preview URL from backend
            dragging: false, // State for drag events
            defaultImage : '123',
            fileChosen(event) {
                const file = event.target.files[0];

                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    Toaster.warning('Invalid file type. Please select an image (PNG, WEBP, JPG)');
                    event.target.value = ''; // Clear the input
                    this.imagePreview = this.defaultImage; // Reset the preview
                    return;
                }

                // Validate file size (max 2 MB)
                const maxSize = 2 * 1024 * 1024; // 2 MB
                if (file.size > maxSize) {
                    Toaster.warning('File size exceeds 2 MB. Please select a smaller image.');
                    event.target.value = ''; // Clear the input
                    this.imagePreview = this.defaultImage; // Reset the preview
                    return;
                }

                // If valid, read the file and set the preview
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.imagePreview = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            handleDrop(event) {
                this.dragging = false; // Reset dragging state
                const files = event.dataTransfer.files;
                if (files.length > 0) {
                    this.fileChosen({ target: { files } }); // Call fileChosen with dropped files
                }
            }
        };
    }
</script>
@endpush
