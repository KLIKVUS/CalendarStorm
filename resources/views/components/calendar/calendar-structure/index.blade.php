<div class="relative basis-full overflow-hidden">
    <div class="absolute left-0 right-0 mr-2.5 mt-8">
        <x-calendar.day-names class="absolute z-[4] w-full" />
    </div>

    <div
        class="relative h-full flex min-h-80 flex-col gap-y-[2px] overflow-x-clip overflow-y-scroll border-t-2 bg-gray-200 dark:border-slate-900 dark:bg-slate-900 [&>div:has(.month-name-spacer):first-of-type_.month-name-spacer]:h-9 [&>div:has(.month-name-spacer):not(:first-of-type)_.month-name-spacer]:hidden"
        x-ref="calendar"
        {{-- :class="{
            'overflow-y-clip': loaderService.isLoading,
            'overflow-y-scroll': !loaderService.isLoading,
        }" --}}
        {{-- x-data="dragScroll()"
        x-on:mousedown="startDrag($event)"
        x-on:mousemove="onDrag($event)"
        x-on:mouseup="stopDrag()"
        x-on:mouseleave="stopDrag()"
        x-on:touchstart="startDrag($event)"
        x-on:touchmove="onDrag($event)"
        x-on:touchend="stopDrag()" --}}
    >
        <template
            x-for="monthData in calendarService.monthsService.months"
            :key="monthData.id"
            hidden
        >
            <x-calendar.calendar-structure.month />
        </template>
    </div>

    <x-calendar.loader />
</div>
