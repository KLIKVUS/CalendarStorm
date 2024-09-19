<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <x-tabler-icon class="dark:text-gray-400 text-gray-500"
            size="lg"
            svg="search" />
        <span class="sr-only">{{ __('Search icon') }}</span>
    </div>
    <input class="dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900 transition-[border-color] focus:border-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-700"
        type="text"
        placeholder="{{ __('Search') }}">
</div>
