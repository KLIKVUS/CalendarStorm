<div
    class="h-6"
    x-data="{
        dayEvent: dayEventsData.events.find(item => item.layer === dayEventLayer),
        currentDate: new Date(monthData.year, monthData.month, day),
    }"
    {{-- :style="{ height: `${dayEvent?.offsetHeight || 30}px` }" --}}
>
    <template x-if="dayEvent">
        <div
            class="absolute left-0 z-[1] flex h-6 items-center justify-center overflow-hidden border-2 bg-[var(--event-color)] px-2 py-0 transition-colors"
            x-data="{
                isSameDay: eventService.eventRender.IsSameDay(dayEvent.data.beginning, currentDate),
                isSameWeek: eventService.eventRender.IsSameWeek(dayEvent.data.ending, currentDate),
                isSameMonth: eventService.eventRender.IsSameMonth(dayEvent.data.ending, currentDate),
                get isEventIntersectMonth() {
                    return eventService.eventRender.IsEventIntersectMonth(
                        dayEvent.data,
                        calendarService.data.selectedYear,
                        calendarService.data.selectedMonth,
                    );
                }
            }"
            x-init="$nextTick(() => { dayEvent.offsetHeight = $el.offsetHeight })"
            @mouseover.stop="dayEvent.isHovered = true"
            @mouseout.stop="dayEvent.isHovered = false"
            :style="{
                'right': eventService.eventRender.GetEventRight(monthData, day, dayEvent.data),
                '--event-color': dayEvent.data.color,
                'filter': isEventIntersectMonth || dayEvent.isHovered ?
                    'brightness(1)' : 'brightness(0.7)',
            }"
            :class="{
                'ml-2 rounded-l-lg': isSameDay,
                'mr-2 rounded-r-lg': isSameWeek && isSameMonth,
                'border-l-0': !isSameDay,
                'border-r-0': !isSameWeek && !isSameMonth,
                'border-blue-700 dark:border-blue-500 z-[2]': dayEvent.isHovered,
                'border-gray-700 dark:border-gray-400': isEventIntersectMonth && !dayEvent.isHovered,
                'text-gray-300 border-gray-300 dark:text-gray-700 dark:border-gray-700':
                    !isEventIntersectMonth && !dayEvent.isHovered,
            }"
        >
            <template x-if="isSameDay || day == 1">
                <p
                    class="truncate text-sm font-medium leading-tight"
                    x-text="dayEvent.data.name"
                ></p>
            </template>
        </div>
    </template>
</div>
