<div class="inline-flex divide-x-2 divide-gray-500 overflow-hidden rounded-md border-2 border-gray-500 shadow-sm">
    <button
        class="inline-flex items-center gap-1 px-2 py-1 text-center text-sm font-medium text-gray-500 shadow-sm hover:bg-slate-100 hover:text-gray-500 dark:hover:bg-gray-700"
        type="button"
    >
        <x-tabler-click-filled class="size-5" />
        {{ __('Показать') }}
    </button>
    <button
        class="inline-flex items-center gap-1 px-2 py-1 text-center text-sm font-medium text-gray-500 shadow-sm hover:bg-slate-100 hover:text-gray-500 dark:hover:bg-gray-700"
        type="button"
    >
        <x-tabler-edit-filled class="size-5" />
        {{ __('Изменить') }}
    </button>
    <button
        class="inline-flex items-center gap-1 px-2 py-1 text-center text-sm font-medium text-gray-500 shadow-sm hover:bg-slate-100 hover:text-gray-500 dark:hover:bg-gray-700"
        type="button"
    >
        <x-tabler-trash-filled class="size-5" />
        {{ __('Удалить') }}
    </button>
</div>
