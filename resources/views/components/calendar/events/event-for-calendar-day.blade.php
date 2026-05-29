<div
   x-init="() => {
        Alpine.nextTick(() => {
            eventLengths[dayEvent.data.id] = eventService.eventRender.GetEventLengthRelativeToWeekDay(
                new Date(monthData.year, monthData.month, day),
                dayEvent.data,
            );
            eventService.eventRender.InsertDivWithHeight(
                $el,
                initialLevelNumber,
                dayEvent.layer,
                weekIndex,
            );
            initialLevelNumber = dayEvent.layer;
        });
    }"
    :style="{ height: `${dayEvent.offsetHeight}px` }"
>
    <div
        x-init="eventService.eventRender.InitEventHeight(dayEvent, $el, weekIndex)"
        @mouseover.stop="dayEvent.isHovered = true"
        @mouseout.stop="dayEvent.isHovered = false"
        class="absolute left-0 z-[1] overflow-hidden border-2 px-2 py-1 transition-colors bg-[var(--event-color)]"
        :style="{
            right: `calc(-${eventService.eventRender.getTrimmedEventLengthInLastWeekOfMonth(new Date(monthData.year, monthData.month, day), eventLengths[dayEvent.data.id]) * 100}% - ${eventService.eventRender.getTrimmedEventLengthInLastWeekOfMonth(new Date(monthData.year, monthData.month, day), eventLengths[dayEvent.data.id]) * 2}px)`,
            '--event-color': dayEvent.data.color,
            filter: eventService.eventRender.IsEventIntersectMonth(dayEvent.data, calendarService.data.selectedYear, calendarService.data.selectedMonth) || dayEvent.isHovered ? 'brightness(1)' : 'brightness(0.7)'
        }"
        :class="{
            'ml-2 rounded-l-lg': eventService.eventRender.IsSameDay(dayEvent.data.beginning, new Date(monthData.year, monthData.month, day)),
            'mr-2 rounded-r-lg': eventService.eventRender.IsSameWeek(dayEvent.data.ending, new Date(monthData.year, monthData.month, day)),
            'border-l-0': !eventService.eventRender.IsSameDay(dayEvent.data.beginning, new Date(monthData.year, monthData.month, day)),
            'border-r-0': !eventService.eventRender.IsSameWeek(dayEvent.data.ending, new Date(monthData.year, monthData.month, day)),
            'border-blue-700 dark:border-blue-500': dayEvent.isHovered,
            'border-gray-700 dark:border-gray-400': eventService.eventRender.IsEventIntersectMonth(dayEvent.data, calendarService.data.selectedYear, calendarService.data.selectedMonth) && !dayEvent.isHovered,
            'text-gray-300 border-gray-300 dark:text-gray-700 dark:border-gray-700': !eventService.eventRender.IsEventIntersectMonth(dayEvent.data, calendarService.data.selectedYear, calendarService.data.selectedMonth) && !dayEvent.isHovered,
        }">
        <p class="truncate text-sm leading-tight" x-text="dayEvent.data.name"></p>
    </div>
</div>
