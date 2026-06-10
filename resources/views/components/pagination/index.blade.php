@if ($paginator->hasPages())
    <div class="flex items-center justify-center gap-2">
        <a
            href="{{ $paginator->previousPageUrl() }}"
            @class([
                'rounded-md px-3 py-1 border',
                'pointer-events-none opacity-50' => $paginator->onFirstPage(),
            ])
        >
            <x-tabler-caret-left-filled class="size-5" />
        </a>

        <span class="text-sm text-gray-500">
            {{ $paginator->currentPage() }}
            /
            {{ $paginator->lastPage() }}
        </span>

        <a
            href="{{ $paginator->nextPageUrl() }}"
            @class([
                'rounded-md px-3 py-1 border',
                'pointer-events-none opacity-50' => !$paginator->hasMorePages(),
            ])
        >
            <x-tabler-caret-right-filled class="size-5" />
        </a>
    </div>
@endif
