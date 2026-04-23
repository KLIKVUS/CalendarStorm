<div
    class="grid grid-cols-7 gap-[2px]"
    :id="monthData.id"
    x-intersect:enter.half="$nextTick(() => calendarService.SelectMonth(monthData.year, monthData.month))"
    x-intersect:leave.threshold.25="$nextTick(() => calendarService.monthsService.MonthUnShown(monthData.id))"
>
    <div
        class="sticky top-0 z-[2] col-span-full h-8 text-center text-lg font-bold"
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

    <template x-if="monthData.leadingEmptyDays">
        <x-calendar.calendar-structure.day ::style="`grid-column: span ${monthData.leadingEmptyDays}`" />
    </template>

    <template
        x-for="day in monthData.daysCount"
        :key="monthData.year+'+'+monthData.month+'+'+day"
        hidden
    >
        <x-calendar.calendar-structure.day
            class="flex flex-col bg-gray-50 dark:bg-gray-800"
            x-on:mouseover="isHovered = true"
            x-on:mouseleave="isHovered = false"
            ::class="{
                'bg-gray-50 dark:bg-gray-800': !isHovered,
                'bg-gray-100 dark:bg-gray-700': isHovered,
            }"
        >
            <div
                class="px-3 py-2 text-center leading-none transition duration-100 ease-in-out sm:mx-2 sm:mt-2 sm:rounded-lg sm:py-0.5"
                x-text="day"
                :class="{
                    'bg-blue-500 text-white dark:text-white': new Date(monthData.year, monthData.month, day).toDateString() === new Date().toDateString(),
                    'text-gray-300 dark:text-gray-700': !calendarService.IsSelectedMonth(monthData.year, monthData.month),
                }">
            </div>

            <div
                class="relative mt-2 space-y-2"
                x-data="{
                    dayEvents: new Date(monthData.year, monthData.month, day).getDay() == 1 || day == 1 ?
                        eventService.GetEventsForDay(monthData.year, monthData.month, day) :
                        eventService.GetEventsStartingOn(monthData.year, monthData.month, day),
                    weekIndex: eventService.eventRender.GetDayWeekIndex(monthData.year, monthData.month, day),
                    initialLevelNumber: 0,
                    eventLengths: {},
                }"
                x-show="dayEvents.length">
                <template x-for="dayEvent in dayEvents" hidden>
                    <x-calendar.events.event-for-calendar-day />
                </template>
            </div>

            <x-calendar.buttons.add-event />
        </x-calendar.calendar-structure.day>
    </template>

    <template x-if="monthData.trailingEmptyDays">
        <x-calendar.calendar-structure.day ::style="`grid-column: span ${monthData.trailingEmptyDays}`" />
    </template>
</div>
