@props([
    'pageTitle' => null,
    'pageDescription' => null,
    'navigationLinks' => [],
    'rightSideBtnText' => '',
    'rightSideBtnRoute' => '',
])

<div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        {{ $pageTitle }}
    </h2>

    <nav>
        <ol class="flex items-center gap-2">

            @foreach ($navigationLinks as $link)
                <li>
                    <a class="{{ $link['link'] == '' ? 'text-primary' : '' }} font-medium"
                        {{ $link['link'] == '' ? '' : 'href=' . route('admin.index') }}>{{ $link['text'] }}
                        {{ $loop->last ? '' : '/' }}</a>
                </li>
            @endforeach
        </ol>
    </nav>
</div>

<div class="mb-2">
    <p>
        {{ $pageDescription }}
    </p>
</div>
@if ($rightSideBtnText != '' && isset($rightSideBtnText))
    <div class="flex">
        <x-primary-button wire:navigate href="{{ $rightSideBtnRoute }}" class="mb-4 ms-auto">
            {{ $rightSideBtnText }}
        </x-primary-button>
    </div>
@endif
