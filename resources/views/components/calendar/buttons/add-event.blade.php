<button
    class="mt-auto flex justify-center py-1 pt-1 text-gray-500 opacity-25 transition-opacity hover:text-blue-800 hover:opacity-70 focus:text-blue-800 focus:opacity-70 dark:hover:text-blue-400 dark:focus:text-blue-400"
    type="button"
    @click="() => {
        const yearF = String(monthData.year).padStart(2, '0')
        const monthF = String(monthData.month + 1).padStart(2, '0')
        const dayF = String(day).padStart(2, '0')
        const date = `${yearF}-${monthF}-${dayF}`
        const newEventData = {
            calendarId: config.calendarId,
            beginning: `${date} 10:00:00`,
            ending: `${date} 20:00:00`,
        };
        $store.modal.SetModalData('EventModal.CreateEvent', newEventData);
        $store.modal.OpenModal('CreateEvent');
    }"
>
    <x-tabler-circle-plus-filled class="size-5" />
</button>
