<button class="dark:bg-zinc-700 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-zinc-200 transition-colors duration-200 ease-in-out focus:border-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-700"
    type="button"
    role="switch"
    aria-checked="false"
    @click="darkMode=!darkMode">
    <span class="sr-only">Use setting</span>
    <span class="dark:translate-x-5 pointer-events-none relative inline-block h-5 w-5 translate-x-0 transform rounded-full bg-white shadow ring-0 transition duration-500 ease-in-out">
        <span class="dark:opacity-0 dark:duration-100 dark:ease-out absolute inset-0 flex h-full w-full items-center justify-center opacity-100 transition-opacity duration-500 ease-in"
            aria-hidden="true">
            <x-tabler-icon class="text-neutral-700"
                svg="sun" />
        </span>
        <span class="dark:opacity-100 dark:duration-200 dark:ease-in absolute inset-0 flex h-full w-full items-center justify-center opacity-0 transition-opacity duration-100 ease-out"
            aria-hidden="true">
            <x-tabler-icon class="text-neutral-700"
                svg="moon" />
        </span>
    </span>
</button>
