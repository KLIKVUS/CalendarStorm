<button
    type="button"
    {{ $attributes->class(['transition-color cursor-pointer rounded-lg p-1 leading-none hover:bg-slate-100 dark:hover:bg-gray-900']) }}
    {{ $attributes }}
>
    {{ $slot }}
</button>
