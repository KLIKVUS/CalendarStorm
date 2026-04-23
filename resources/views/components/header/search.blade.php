<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
        <x-tabler-search class="size-5 dark:text-gray-400 text-gray-500" />
        <span class="sr-only">{{ __('Search icon') }}</span>
    </div>

    <input
        class="w-full dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 block rounded-lg border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900 focus:outline-none"
        type="search"
        name="search"
        placeholder="{{ __('Search') }}"
    >
</div>
