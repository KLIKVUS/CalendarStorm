<div
    class="grid grid-cols-7 gap-[2px]"
    :id="monthData.id"
    x-intersect:enter.margin.-50%="$nextTick(() => !loaderService.isLoading && calendarService.SelectMonth(monthData.year, monthData.month))"
    x-intersect:leave.margin.30%="$nextTick(() => !loaderService.isLoading && calendarService.monthsService.MonthUnShown(monthData.id))"
>
    <div
        class="sticky top-0 z-[3] col-span-full h-8 text-center text-lg font-bold"
        x-text="`${window.translations.calendar.months[monthData.monthName]} ${monthData.year}`"
        :class="{
            'bg-blue-500 dark:bg-blue-500 text-white dark:text-white': new Date(monthData.year, monthData.month, 1)
                .toDateString() === new Date(new Date().getFullYear(), new Date().getMonth(), 1).toDateString(),
            'bg-gray-50 dark:bg-gray-800': new Date(monthData.year, monthData.month, 1).toDateString() !== new Date(
                new Date().getFullYear(), new Date().getMonth(), 1).toDateString(),
            'text-gray-300 dark:text-gray-700': !calendarService.IsSelectedMonth(monthData.year, monthData.month),
        }"
    ></div>
    <div class="month-name-spacer col-span-full"></div>

    <template
        x-if="monthData.leadingEmptyDays"
        hidden
    >
        <x-calendar.calendar-structure.day ::style="`grid-column: span ${monthData.leadingEmptyDays}`" />
    </template>

    <template
        x-for="day in monthData.daysCount"
        :key="monthData.id + '-' + day"
        hidden
    >
        <x-calendar.calendar-structure.day
            class="flex flex-col bg-gray-50 dark:bg-gray-800"
            x-data="{ hovered: false }"
            @mouseover.self="hovered = true"
            @mouseout.self="hovered = false"
            ::class="{
                '!bg-gray-100 dark:!bg-gray-700': hovered,
            }"
        >
            <div
                class="px-3 py-2 text-center leading-none transition duration-100 ease-in-out sm:m-2 sm:rounded-lg sm:py-0.5"
                x-text="day"
                :class="{
                    'bg-blue-500 text-white dark:text-white': new Date(monthData.year, monthData.month, day)
                        .toDateString() === new Date().toDateString(),
                    'text-gray-300 dark:text-gray-700': !calendarService.IsSelectedMonth(monthData.year, monthData
                        .month),
                }"
            >
            </div>

            <div
                class="relative space-y-2"
                x-data="{
                    dayIndex: eventService.eventRender.GetDayIndex(monthData.year, monthData.month, day),
                }"
            >
                <template
                    x-if="eventService.eventsByDay[dayIndex]"
                    hidden
                >
                    <template
                        x-for="(dayEvents, eventLayer) in eventService.eventsByDay[dayIndex].events"
                        :key="dayIndex + '-' + eventLayer"
                        hidden
                    >
                        <div class="h-6">
                            <template
                                x-if="dayEvents && dayEvents[0]"
                                hidden
                            >
                                <x-calendar.events.event-for-calendar-day dayEvent="dayEvents[0]" />
                            </template>
                            <template
                                x-if="dayEvents && dayEvents[1]"
                                hidden
                            >
                                <x-calendar.events.event-for-calendar-day dayEvent="dayEvents[1]" />
                            </template>
                        </div>
                    </template>
                </template>
            </div>

            <template x-if="config.rights_of_the_current_user.is_user_can_create_events != false">
                <x-calendar.buttons.add-event />
            </template>
        </x-calendar.calendar-structure.day>
    </template>

    <template x-if="monthData.trailingEmptyDays">
        <x-calendar.calendar-structure.day ::style="`grid-column: span ${monthData.trailingEmptyDays}`" />
    </template>
</div>
