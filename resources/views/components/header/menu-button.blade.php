<button
    type="button"
    {{ $attributes->class('dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700 rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none') }}
>
    {{ $slot }}
    <span class="sr-only">{{ $hint }}</span>
</button>
