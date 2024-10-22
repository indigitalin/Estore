<div class="flex items-center">
    <div class="me-auto">
        <p class="text-gray-700 leading-5 dark:text-gray-400">
            {!! __('Showing') !!}
            @if ($paginator->firstItem())
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            {!! __('of') !!}
            <span class="font-medium">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </p>
    </div>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <x-secondary-button class="bg-white me-2 text-gray-400">
                {!! __('pagination.previous') !!}
            </x-secondary-button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                <x-secondary-button class="bg-white me-2">
                    {!! __('pagination.previous') !!}
                </x-secondary-button>
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                <x-secondary-button class="bg-white">
                    {!! __('pagination.next') !!}
                </x-secondary-button>
            </a>
        @else
            <x-secondary-button class="bg-white text-gray-400">
                {!! __('pagination.next') !!}
            </x-secondary-button>
        @endif
    </nav>
</div>