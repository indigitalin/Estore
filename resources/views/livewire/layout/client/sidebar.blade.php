<aside :class="sidebarToggle ? 'translate-x-0' : '-translate-x-full'"
    class="absolute left-0 top-0 z-9999 flex h-screen w-72.5 flex-col overflow-y-hidden bg-black duration-300 ease-linear dark:bg-boxdark lg:static lg:translate-x-0"
    @click.outside="sidebarToggle = false">
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
        <a href="/" class="text-white text-2xl flex items-center">
            <box-icon color="#dee4ee" name='store-alt'></box-icon> <span class="ms-2
            ">Estore</span>
        </a>
    </div>
    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
        <nav class="mt-5 px-4 py-4 lg:mt-9 lg:px-6" x-data="{ selected: $persist('Dashboard') }">
            <div>
                <h3 class="mb-4 ml-4 text-sm font-medium text-bodydark2">MENU</h3>
                <ul class="mb-6 flex flex-col gap-1.5">
                    <li>
                       
                        <a wire:navigate class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('client.index') }}"
                            @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Dashboard') && (page === 'Dashboard') }"
                            :class="page === 'Dashboard' && 'bg-graydark'">
                            <box-icon color="#dee4ee" name='chart'></box-icon>
                            Dashboard
                        </a>
                    </li>
                    <li>
                       
                        <a wire:navigate class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('client.categories.index') }}"
                            @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Dashboard') && (page === 'Dashboard') }"
                            :class="page === 'Dashboard' && 'bg-graydark'">
                            <box-icon color="#dee4ee" name='category'></box-icon>
                            Categories
                        </a>
                    </li>
                    <li>
                       
                        <a wire:navigate class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('client.collections.index') }}"
                            @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Dashboard') && (page === 'Dashboard') }"
                            :class="page === 'Dashboard' && 'bg-graydark'">
                            <box-icon color="#dee4ee" name='collection'></box-icon>
                            Collections
                        </a>
                    </li>
                    <li>
                       
                        <a wire:navigate class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('client.stores.index') }}"
                            @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Dashboard') && (page === 'Dashboard') }"
                            :class="page === 'Dashboard' && 'bg-graydark'">
                            <box-icon color="#dee4ee" name='store'></box-icon>
                            Stores
                        </a>
                    </li>
                    <li>
                       
                        <a wire:navigate class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="{{ route('client.websites.index') }}"
                            @click="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Dashboard') && (page === 'Dashboard') }"
                            :class="page === 'Dashboard' && 'bg-graydark'">
                            <box-icon color="#dee4ee" name='globe'></box-icon>
                            Websites
                        </a>
                    </li>
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                        wire:navigate href="{{ route('client.users.index') }}" @click="selected = (selected === 'Users' ? '':'Users')"
                            :class="{ 'bg-graydark dark:bg-meta-4': (selected === 'Users') && (page === 'Users') }"
                            :class="page === 'Users' && 'bg-graydark'">
                            <box-icon name='user-check' color="#dee4ee"></box-icon>
                            Users
                        </a>
                    </li>
                    <li>
                        <a class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark1 duration-300 ease-in-out hover:bg-graydark dark:hover:bg-meta-4"
                            href="#" @click.prevent="selected = (selected === 'Settings' ? '':'Settings')"
                            :class="{
                                'bg-graydark dark:bg-meta-4': (selected === 'Settings') || (
                                    page === 'ecommerce' || page === 'analytics' || page === 'stocks')
                            }">
                            <box-icon name='cog' color="#dee4ee"></box-icon>

                            Settings

                            <svg class="absolute right-4 top-1/2 -translate-y-1/2 fill-current"
                                :class="{ 'rotate-180': (selected === 'Settings') }" width="20" height="20"
                                viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.41107 6.9107C4.73651 6.58527 5.26414 6.58527 5.58958 6.9107L10.0003 11.3214L14.4111 6.91071C14.7365 6.58527 15.2641 6.58527 15.5896 6.91071C15.915 7.23614 15.915 7.76378 15.5896 8.08922L10.5896 13.0892C10.2641 13.4147 9.73651 13.4147 9.41107 13.0892L4.41107 8.08922C4.08563 7.76378 4.08563 7.23614 4.41107 6.9107Z"
                                    fill="" />
                            </svg>
                        </a>

                        <!-- Dropdown Menu Start -->
                        <div class="translate transform overflow-hidden"
                            :class="(selected === 'Settings') ? 'block' : 'hidden'">
                            <ul class="mb-5.5 mt-4 flex flex-col gap-2.5 pl-6">
                                <li>
                                    <a wire:navigate
                                        class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="{{ route('client.roles.index') }}" :class="page === 'roles-responsibilities' && '!text-white'">Roles and
                                        Responsibilities
                                    </a>
                                </li>
                                <li>
                                    <a wire:navigate
                                        class="group relative flex items-center gap-2.5 rounded-md px-4 font-medium text-bodydark2 duration-300 ease-in-out hover:text-white"
                                        href="{{ route('client.settings') }}" :class="page === 'ecommerce' && '!text-white'">Company
                                        Settings
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- Dropdown Menu End -->
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</aside>
