<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <x-tabler-search class="size-5 text-gray-500 dark:text-gray-400" />
        <span class="sr-only">{{ __('Search icon') }}</span>
    </div>

    <input
        class="block w-full rounded-lg border-2 border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
        name="search"
        type="search"
        placeholder="{{ __('Search') }}"
    >
</div>
