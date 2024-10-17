<div
    class="overflow-hidden rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div class="relative z-20 h-35 sm:h-44">
        <img src="https://ui-avatars.com/api//?background=9e9e9e&color=fff&name=" alt="profile cover"
            class="h-full w-full rounded-tl-sm rounded-tr-sm object-cover object-center" />
        
    </div>
    {{-- @dump($this) --}}
    <div class="px-4 pb-6 text-center lg:pb-8 xl:pb-11.5">
        <div
            class="relative z-30 mx-auto -mt-22 h-30 w-full max-w-30 rounded-full bg-white/20 p-1 backdrop-blur sm:h-44 sm:max-w-44 sm:p-3">
            <div class="relative drop-shadow-2">
                <img src="{{ $user->picture_url }}" class="rounded-full w-full" alt="Brand">
            </div>
        </div>
        <div class="mt-4">
            <h3 class="mb-1.5 text-2xl font-medium text-black dark:text-white capitalize">
                {{ $user->name }}
            </h3>
            <i class="font-medium capitalize">{{ $user->type }}</i>
            
            <div
                class="mx-auto mb-5.5 mt-4.5 grid max-w-xl grid-cols-2 rounded-md border border-stroke py-2.5 shadow-1 dark:border-strokedark dark:bg-[#37404F]">
                
                <div
                    class="flex flex-row gap-2 items-center justify-center  border-r border-stroke px-4 dark:border-strokedark xsm:flex-row">
                     <span class="font-semibold mt-2">
                        <box-icon name='phone-call' ></box-icon>
                        </span>
                    <a href="tel:{{ $user->phoneNumber }}" class="text-black dark:text-white ">
                       
                        {{ $user->phoneNumber }}
                    </a>
                </div>
                <div
                    class="flex flex-row gap-2 items-center justify-center  border-r border-stroke px-4 dark:border-strokedark xsm:flex-row">
                     <span class="font-semibold mt-2">
                            <box-icon name='envelope' ></box-icon>
                        </span>
                    <a href="mailto:{{ $user->email }}" class="text-black dark:text-white ">
                       
                        {{ $user->email }}
                    </a>
                </div>
            </div>


            <div class="mx-auto max-w-180 mt-5">
                <div class="flex flex-col gap-2 items-center  ">
                    <p class="mt-4.5 text-sm font-normal">
                        Account Created :  {{ $user->created_at }}
                     </p>
                     <p class="mt-4.5 text-sm font-normal">
                        Last Login :  {{ $user->last_login }}
                     </p>
                </div>
            </div>
            <div class="mx-auto max-w-180 mt-5">
                <div class="flex flex-row gap-2 justify-center  items-center">
                     Account Status :
                     <p
                        class="inline-flex rounded-full {{ $user->status == 1  ? 'bg-success' : 'bg-danger' }}  bg-opacity-10 px-3 py-1 text-sm font-medium {{ $user->status == 1  ? 'text-success' : 'text-danger' }}">
                         {{ $user->status_label }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
