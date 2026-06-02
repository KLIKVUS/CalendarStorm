<div
    class="grid grid-cols-7 gap-[2px]"
    :id="monthData.id"
    x-intersect:enter.margin.-50%="$nextTick(() => !loaderService.isLoading &&  calendarService.SelectMonth(monthData.year, monthData.month))"
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

    <template x-if="monthData.leadingEmptyDays">
        <x-calendar.calendar-structure.day ::style="`grid-column: span ${monthData.leadingEmptyDays}`" />
    </template>

    <template
        x-for="day in monthData.daysCount"
        :key="monthData.id + '-' + day"
        hidden
    >
        <x-calendar.calendar-structure.day
            class="flex flex-col bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700"
        >
            <div
                class="px-3 py-2 text-center leading-none transition duration-100 ease-in-out sm:mx-2 sm:mt-2 sm:rounded-lg sm:py-0.5"
                x-text="day"
                :class="{
                    'bg-blue-500 text-white dark:text-white': new Date(monthData.year, monthData.month, day)
                        .toDateString() === new Date().toDateString(),
                    'text-gray-300 dark:text-gray-700': !calendarService.IsSelectedMonth(monthData.year, monthData
                        .month),
                }"
            >
            </div>

            <template
                x-if="!loaderService.isLoading"
                hidden
            >
                <div
                    class="relative mt-2 space-y-2"
                    x-data="{
                        dayIndex: '',
                        dayEventsData: {}
                    }"
                    x-init="() => {
                        dayIndex = eventService.eventRender.GetDayIndex(monthData.year, monthData.month, day);
                        dayEventsData = eventService.eventsByWeek[dayIndex];
                    }"
                >
                    <template x-if="dayEventsData">
                        <template
                            x-for="dayEventLayer in dayEventsData.layersCount"
                            :key="dayIndex + '-' + dayEventLayer"
                            hidden
                        >
                            <x-calendar.events.event-for-calendar-day />
                        </template>
                    </template>
                </div>
            </template>

            <x-calendar.buttons.add-event />
        </x-calendar.calendar-structure.day>
    </template>

    <template x-if="monthData.trailingEmptyDays">
        <x-calendar.calendar-structure.day ::style="`grid-column: span ${monthData.trailingEmptyDays}`" />
    </template>
</div>
