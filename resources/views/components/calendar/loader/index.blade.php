<div
    class="absolute bottom-0 left-0 right-0 top-0 z-[2] select-none"
    x-data="{ isOpen: loaderService.data.isLoading }"
    x-show="isOpen"
    x-init="$watch('loaderService.data', (value) => isOpen = value.isLoading)"
    x-transition:enter="transition ease-out duration-500 delay-0"
    x-transition:enter-start="opacity-75"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-500 delay-0"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
>
    <div
        class="sticky top-0 flex h-full w-full flex-col items-center justify-center bg-gray-50 p-4 md:p-5 dark:bg-gray-800">
        <x-tabler-loader-2
            class="size-10 inline-block animate-spin text-blue-600 dark:text-blue-500"
            role="status"
            aria-label="loading"
        >
            <span class="sr-only">Loading...</span>
        </x-tabler-loader-2>
    </div>
</div>
