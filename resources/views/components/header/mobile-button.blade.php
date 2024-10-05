<button class="dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700 rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 lg:hidden"
    type="button"
    {{ $attributes }}>
    {{ $slot }}
    <span class="sr-only">{{ $hint }}</span> 
</button>
