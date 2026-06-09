@props(['dayEvent'])

<div
    class="absolute left-0 z-[1] flex h-6 items-center justify-center overflow-hidden border-2 bg-[var(--event-color)] px-2 py-0 transition-colors"
    x-data="{
        currentDate: undefined,
        isSameDay: undefined,
        isSameWeek: undefined,
        isSameMonth: undefined,
        isEventIntersectMonth: undefined,
        openEventModal: function() {
            if (!{{ $dayEvent }}.globalData.data.rights_of_the_current_user.is_user_can_update) return;
            modalService.OpenModal('EditEvent');
            modalService.SetModalData('EventModal', {{ $dayEvent }}.globalData.data);
        }
    }"
    x-init="() => {
        $nextTick(() => {
            currentDate = new Date(monthData.year, monthData.month, day);
            isSameDay = eventService.eventRender.IsSameDay({{ $dayEvent }}.globalData.data.beginning, currentDate);
            isSameWeek = eventService.eventRender.IsSameWeek({{ $dayEvent }}.globalData.data.ending, currentDate);
            isSameMonth = eventService.eventRender.IsSameMonth({{ $dayEvent }}.globalData.data.ending, currentDate);
            isEventIntersectMonth = eventService.eventRender.IsEventIntersectMonth({{ $dayEvent }}.globalData.data, calendarService.data.selectedYear, calendarService.data.selectedMonth);
        });

        $watch(() => [
            calendarService.data.selectedMonth,
            calendarService.data.selectedYear,
        ], ([newMonth, newYear], [oldMonth, oldYear]) => {
            if (
                newMonth == oldMonth &&
                newYear == oldYear &&
                isEventIntersectMonth != undefined
            ) return;

            isEventIntersectMonth = eventService.eventRender.IsEventIntersectMonth({{ $dayEvent }}.globalData.data, newYear, newMonth);
        })
    }"
    @mouseover.stop="{{ $dayEvent }}.globalData.isHovered = true"
    @mouseout.stop="{{ $dayEvent }}.globalData.isHovered = false"
    :style="{
        'right': eventService.eventRender.GetEventRight(monthData, day, {{ $dayEvent }}.globalData),
        '--event-color': {{ $dayEvent }}.globalData.data.color,
        'filter': isEventIntersectMonth || {{ $dayEvent }}.globalData.isHovered ?
            'brightness(1)' : 'brightness(0.5) opacity(0.5)',
    }"
    :class="{
        'ml-[52.5%]': {{ $dayEvent }}.adjacent.left,
        'mr-[52.5%]': {{ $dayEvent }}.adjacent.right,
        'ml-2 rounded-l-lg': isSameDay,
        'mr-2 rounded-r-lg': isSameWeek && isSameMonth,
        'border-l-0': !isSameDay,
        'border-r-0': !isSameWeek || !isSameMonth,
        'border-blue-700 dark:border-blue-500 z-[2]': {{ $dayEvent }}.globalData.isHovered,
        'border-gray-700 dark:border-gray-400': isEventIntersectMonth && !{{ $dayEvent }}.globalData.isHovered,
        'text-gray-300 border-gray-300 dark:text-gray-700 dark:border-gray-700':
            !isEventIntersectMonth && !{{ $dayEvent }}.globalData.isHovered,
    }"
    @click="openEventModal()"
>
    {{-- <span
        class="absolute left-0 text-xs text-slate-500"
        x-text="'#'+{{ $dayEvent }}.globalData.data.id"
    ></span> --}}
    <template
        x-if="isSameDay || day == 1"
        hidden
    >
        <p
            class="truncate text-sm font-medium leading-tight"
            x-text="{{ $dayEvent }}.globalData.data.name"
        ></p>
    </template>
</div>
