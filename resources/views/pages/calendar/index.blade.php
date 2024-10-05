@extends('layouts.base')

@section('page.title', 'Календарь')

@push('head.js')
    <script>
        window.translations = @json([
            'calendar' => __('calendar'),
        ]);
    </script>
@endpush

@section('content')
    <div x-data="generalCalendar"
        x-init="[initMonths()]"
        x-cloak>
        <div class="dark:bg-gray-800 overflow-hidden rounded-lg bg-gray-50 shadow">
            <div class="mb-3 mt-2 flex items-center justify-between pl-3">
                <div>
                    <span class="text-lg font-bold"
                        x-text="window.translations.calendar.months[calendar_data.selected_month_name]"></span>
                    <span class="ml-1 text-lg font-normal text-gray-600"
                        x-text="calendar_data.selected_year"></span>
                </div>
                <div class="flex items-center gap-1">
                    <button class="transition-color dark:hover:bg-gray-900 cursor-pointer rounded-lg p-1 leading-none hover:bg-slate-100"
                        type="button"
                        @click="switchToPreviousMonth()">
                        <x-tabler-icon size="2xl"
                            svg="caret-left-filled" />
                    </button>
                    <button class="transition-color dark:hover:bg-gray-900 cursor-pointer rounded-lg p-1 py-2 leading-none hover:bg-slate-100"
                        type="button"
                        :class="{ 'opacity-25': isCurrentMonth() }"
                        :disabled="isCurrentMonth() ? true : false"
                        @click="switchToCurrentMonth()">
                        {{ __('Today') }}
                    </button>
                    <button class="transition-color dark:hover:bg-gray-900 cursor-pointer rounded-lg p-1 leading-none hover:bg-slate-100"
                        type="button"
                        @click="switchToNextMonth()">
                        <x-tabler-icon size="2xl"
                            svg="caret-right-filled" />
                    </button>
                </div>
            </div>

            <div class="dark:bg-gray-800 dark:border-gray-900 dark:divide-gray-900 flex flex-wrap divide-x-2 border-t-2 bg-gray-50 pr-2.5">
                <template x-for="(day, day_index) in calendar_data.DAY_NAMES"
                    :key="day_index"
                    hidden>
                    <div class="flex-1 px-2 py-2">
                        <div class="text-center text-sm font-bold uppercase tracking-wide text-gray-600"
                            x-text="window.translations.calendar.days_short[day]"></div>
                    </div>
                </template>
            </div>

            <div class="relative">
                <div class="min-h-80 h-[70vh] max-h-[1000px] overflow-scroll overflow-x-hidden"
                    x-ref="calendar">
                    <div class="dark:divide-gray-900 divide-y-2">
                        <template x-for="(month_data, month_index_in_array) in calendar_data.calendar_months"
                            :key="month_data.index"
                            hidden>
                            <div class="dark:divide-gray-900 divide-y-2"
                                :id="month_data.index"
                                x-intersect:enter.threshold.50="handleIntersectEnterMonth(month_data.index, month_data.year, month_data.month, month_index_in_array)"
                                x-intersect:leave.full="handleIntersectLeaveMonth(month_data.index, month_data.year, month_data.month, month_index_in_array)">
                                <template x-for="week_data in month_data.weeks"
                                    :key="week_data.index"
                                    hidden>
                                    <div class="dark:divide-gray-900 flex divide-x-2">
                                        <template x-for="(day_data, day_index) in week_data.days"
                                            :key="day_data.day_index"
                                            hidden>
                                            <div class="min-h-40 relative flex-1 overflow-auto px-4 pt-2">
                                                <div class="inline-flex h-6 w-9 cursor-pointer items-center justify-center rounded-full text-center leading-none transition duration-100 ease-in-out"
                                                    x-text="day_data.day"
                                                    :class="{
                                                        'bg-blue-500 text-white hover:bg-blue-300 hover:text-gray-700': isToday(day_data.year, day_data.month, day_data.day),
                                                        'dark:text-white hover:bg-blue-300 hover:text-gray-700': isSelectedMonth(day_data.year, day_data.month) && !isToday(day_data.year, day_data.month, day_data.day),
                                                        'text-gray-300 dark:text-gray-700 hover:bg-blue-300': !isSelectedMonth(day_data.year, day_data.month),
                                                    }"></div>
                                                <div class="mt-1">
                                                    {{-- <div class="absolute right-0 top-0 mr-2 mt-2 inline-flex h-6 w-6 items-center justify-center rounded-full bg-gray-700 text-sm leading-none text-white" x-show="events.filter(e => e.event_date === new Date(year, month, date).toDateString()).length" x-text="events.filter(e => e.event_date === new Date(year, month, date).toDateString()).length"></div> --}}

                                                    {{-- <template x-for="event in events.filter(e => new Date(e.event_date).toDateString() ===  new Date(year, month, date).toDateString())">
                                        <div class="mt-1 overflow-hidden rounded-lg border px-2 py-1"
                                            :class="{
                                                'border-blue-200 text-blue-800 bg-blue-100': event.event_theme === 'blue',
                                                'border-red-200 text-red-800 bg-red-100': event.event_theme === 'red',
                                                'border-yellow-200 text-yellow-800 bg-yellow-100': event.event_theme === 'yellow',
                                                'border-green-200 text-green-800 bg-green-100': event.event_theme === 'green',
                                                'border-purple-200 text-purple-800 bg-purple-100': event.event_theme === 'purple'
                                            }">
                                            <p class="truncate text-sm leading-tight"
                                                x-text="event.event_title"></p>
                                        </div>
                                    </template> --}}
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- <div class="absolute bottom-0 left-0 right-0 top-0 z-[1]"
                    x-show="!calendar_data.is_initialized || !calendar_data.is_scrolled"
                    x-transition:enter="transition ease-out duration-300 delay-0"
                    x-transition:enter-start="opacity-50"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-500 delay-0"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <div class="dark:bg-gray-800 sticky top-0 flex h-full w-full flex-col items-center justify-center bg-gray-50 p-4 md:p-5">
                        <x-tabler-icon class="dark:text-blue-500 inline-block animate-spin text-5xl text-blue-600"
                            role="status"
                            aria-label="loading"
                            svg="loader-2">
                            <span class="sr-only">Loading...</span>
                        </x-tabler-icon>
                    </div>
                </div> --}}
            </div>
        </div>

        <!-- Modal -->
        {{-- <div class="fixed bottom-0 left-0 right-0 top-0 z-40 h-full w-full"
            style=" background-color: rgba(0, 0, 0, 0.8)"
            x-show.transition.opacity="open_event_modal">
            <div class="absolute left-0 right-0 mx-auto mt-24 max-w-xl overflow-hidden p-4">
                <div class="absolute right-0 top-0 inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-white text-gray-500 shadow hover:text-gray-800"
                    x-on:click="open_event_modal = !open_event_modal">
                    <svg class="h-6 w-6 fill-current"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24">
                        <path d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                    </svg>
                </div>

                <div class="block w-full overflow-hidden rounded-lg bg-white p-8 shadow">

                    <h2 class="mb-6 border-b pb-2 text-2xl font-bold text-gray-800">Add Event Details</h2>

                    <div class="mb-4">
                        <label class="mb-1 block text-sm font-bold tracking-wide text-gray-800">Event title</label>
                        <input class="w-full appearance-none rounded-lg border-2 border-gray-200 bg-gray-200 px-4 py-2 leading-tight text-gray-700 focus:border-blue-500 focus:bg-white focus:outline-none"
                            type="text"
                            x-model="event_title">
                    </div>

                    <div class="mb-4">
                        <label class="mb-1 block text-sm font-bold tracking-wide text-gray-800">Event date</label>
                        <input class="w-full appearance-none rounded-lg border-2 border-gray-200 bg-gray-200 px-4 py-2 leading-tight text-gray-700 focus:border-blue-500 focus:bg-white focus:outline-none"
                            type="text"
                            x-model="event_date"
                            readonly>
                    </div>

                    <div class="mb-4 inline-block w-64">
                        <label class="mb-1 block text-sm font-bold tracking-wide text-gray-800">Select a theme</label>
                        <div class="relative">
                            <select class="block w-full appearance-none rounded-lg border-2 border-gray-200 bg-gray-200 px-4 py-2 pr-8 leading-tight text-gray-700 hover:border-gray-500 focus:border-blue-500 focus:bg-white focus:outline-none"
                                @change="event_theme = $event.target.value;"
                                x-model="event_theme">
                                <template x-for="(theme, index) in themes">
                                    <option :value="theme.value"
                                        x-text="theme.label"></option>
                                </template>

                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="h-4 w-4 fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 text-right">
                        <button class="mr-2 rounded-lg border border-gray-300 bg-white px-4 py-2 font-semibold text-gray-700 shadow-sm hover:bg-gray-100"
                            type="button"
                            @click="open_event_modal = !open_event_modal">
                            Cancel
                        </button>
                        <button class="rounded-lg border border-gray-700 bg-gray-800 px-4 py-2 font-semibold text-white shadow-sm hover:bg-gray-700"
                            type="button"
                            @click="addEvent()">
                            Save Event
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- /Modal -->
    </div>
@endsection
