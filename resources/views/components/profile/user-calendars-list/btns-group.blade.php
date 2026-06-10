<div
    class="inline-flex divide-x-2 divide-gray-500 overflow-hidden rounded-md border-2 border-gray-500 shadow-sm"
    x-data
>
    <a
        class="inline-flex cursor-pointer items-center gap-1 px-2 py-1 text-center text-sm font-medium text-gray-500 shadow-sm hover:bg-slate-100 hover:text-gray-500 dark:hover:bg-gray-700"
        type="button"
        :href="'/profile/{{ $userId }}?cal={{ $calendar->id }}'"
    >
        <x-tabler-click-filled class="size-5" />
        {{ __('Показать') }}
    </a>
    @if ($calendar->is_user_can_update)
        <button
            class="inline-flex cursor-pointer items-center gap-1 px-2 py-1 text-center text-sm font-medium text-gray-500 shadow-sm hover:bg-slate-100 hover:text-gray-500 dark:hover:bg-gray-700"
            type="button"
            @click="() => {
                $store.modal.SetModalData('CalendarModal.UpdateCalendar', { id: {{ $calendar->id }}, name: '{{ $calendar->name }}', });
                $store.modal.OpenModal('UpdateCalendar');
            }"
        >
            <x-tabler-edit-filled class="size-5" />
            {{ __('Изменить') }}
        </button>
    @endif

    @if ($calendar->is_user_can_delete)
        <form
            action="{{ route('calendars.destroy', $calendar) }}"
            method="POST"
        >
            @csrf
            @method('DELETE')

            <button
                class="inline-flex cursor-pointer items-center gap-1 px-2 py-1 text-center text-sm font-medium text-gray-500 shadow-sm hover:bg-slate-100 hover:text-gray-500 dark:hover:bg-gray-700"
                type="submit"
            >
                <x-tabler-trash-filled class="size-5" />
                {{ __('Удалить') }}
            </button>
        </form>
    @endif
</div>
