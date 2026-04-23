<button
    {{ $attributes->class([
        'dark:bg-zinc-700 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-zinc-200 focus:outline-none',
    ]) }}
    type="button"
    role="switch"
    aria-checked="dark_mode"
    @click="toggleDarkMod()"
>
    <span class="sr-only">Use setting</span>
    <span class="flex dark:translate-x-5 pointer-events-none relative inline-block h-5 w-5 translate-x-0 transform rounded-full bg-white shadow ring-0 transition duration-500 ease-in-out">
        <span class="dark:opacity-0 dark:duration-100 dark:ease-out absolute inset-0 flex h-full w-full items-center justify-center opacity-100 transition-opacity duration-500 ease-in"
            aria-hidden="true">
            <x-tabler-sun class="text-neutral-700 size-4" />
        </span>
        <span class="dark:opacity-100 dark:duration-200 dark:ease-in absolute inset-0 flex h-full w-full items-center justify-center opacity-0 transition-opacity duration-100 ease-out"
            aria-hidden="true">
            <x-tabler-moon class="text-neutral-700 size-4" />
        </span>
    </span>
</button>
