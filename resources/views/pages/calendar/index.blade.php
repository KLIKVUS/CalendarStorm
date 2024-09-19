@extends('layouts.base')

@section('page.title', 'Календарь')

@section('content')
    <div id="general-calendar"
        x-data="app()"
        x-init="[initDate(), getNoOfDays()]"
        x-cloak>
        <div class="overflow-hidden rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-lg font-bold"
                        x-text="MONTH_NAMES[month]"></span>
                    <span class="ml-1 text-lg font-normal text-gray-600"
                        x-text="year"></span>
                </div>
                <div class="flex items-center gap-1">
                    <button class="cursor-pointer rounded-lg p-1 leading-none transition duration-100 ease-in-out hover:bg-gray-600"
                        type="button"
                        :class="{ 'opacity-25': month == 0 }"
                        :disabled="month == 0 ? true : false"
                        @click="month--; getNoOfDays()">
                        <x-tabler-icon size="2xl"
                            svg="caret-left-filled" />
                    </button>
                    {{-- <div class="h-5 border-r-2"></div> --}}
                    <button class="cursor-pointer rounded-lg p-1 py-2 leading-none transition duration-100 ease-in-out hover:bg-gray-600"
                        type="button">
                        {{ __('Today') }}
                    </button>
                    {{-- <div class="h-6 border-r-2"></div> --}}
                    <button class="cursor-pointer rounded-lg p-1 leading-none transition duration-100 ease-in-out hover:bg-gray-600"
                        type="button"
                        :class="{ 'opacity-25': month == 11 }"
                        :disabled="month == 11 ? true : false"
                        @click="month++; getNoOfDays()">
                        <x-tabler-icon size="2xl"
                            svg="caret-right-filled" />
                    </button>
                </div>
            </div>
            <div class="mt-5">
                <div class="flex flex-wrap"
                    style="margin-bottom: -40px;">
                    <template x-for="(day, index) in DAYS"
                        :key="index">
                        <div class="px-2 py-2"
                            style="width: 14.26%">
                            <div class="text-center text-sm font-bold uppercase tracking-wide text-gray-600"
                                x-text="day"></div>
                        </div>
                    </template>
                </div>

                <div class="flex flex-wrap border-l border-t">
                    <template x-for="blankday in blankdays">
                        <div class="border-b border-r px-4 pt-2 text-center"
                            style="width: 14.28%; height: 120px"></div>
                    </template>
                    <template x-for="(date, dateIndex) in no_of_days"
                        :key="dateIndex">
                        <div class="relative border-b border-r px-4 pt-2"
                            style="width: 14.28%; height: 120px">
                            <div class="inline-flex h-6 w-6 cursor-pointer items-center justify-center rounded-full text-center leading-none transition duration-100 ease-in-out"
                                @click="showEventModal(date)"
                                x-text="date"
                                :class="{ 'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"></div>
                            <div class="mt-1 overflow-y-auto"
                                style="height: 80px;">
                                <!-- <div class="absolute right-0 top-0 mr-2 mt-2 inline-flex h-6 w-6 items-center justify-center rounded-full bg-gray-700 text-sm leading-none text-white" x-show="events.filter(e => e.event_date === new Date(year, month, date).toDateString()).length" x-text="events.filter(e => e.event_date === new Date(year, month, date).toDateString()).length"></div> -->

                                <template x-for="event in events.filter(e => new Date(e.event_date).toDateString() ===  new Date(year, month, date).toDateString() )">
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
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="fixed bottom-0 left-0 right-0 top-0 z-40 h-full w-full"
            style=" background-color: rgba(0, 0, 0, 0.8)"
            x-show.transition.opacity="openEventModal">
            <div class="absolute relative left-0 right-0 mx-auto mt-24 max-w-xl overflow-hidden p-4">
                <div class="absolute right-0 top-0 inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-white text-gray-500 shadow hover:text-gray-800"
                    x-on:click="openEventModal = !openEventModal">
                    <svg class="h-6 w-6 fill-current"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24">
                        <path d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z" />
                    </svg>
                </div>

                <div class="block w-full w-full overflow-hidden rounded-lg bg-white p-8 shadow">

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
                            @click="openEventModal = !openEventModal">
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
        </div>
        <!-- /Modal -->
    </div>

    <script>
        const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        function app() {
            return {
                month: '',
                year: '',
                no_of_days: [],
                blankdays: [],
                days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],

                events: [{
                        event_date: new Date(2020, 3, 1),
                        event_title: "April Fool's Day",
                        event_theme: 'blue'
                    },

                    {
                        event_date: new Date(2020, 3, 10),
                        event_title: "Birthday",
                        event_theme: 'red'
                    },

                    {
                        event_date: new Date(2020, 3, 16),
                        event_title: "Upcoming Event",
                        event_theme: 'green'
                    }
                ],
                event_title: '',
                event_date: '',
                event_theme: 'blue',

                themes: [{
                        value: "blue",
                        label: "Blue Theme"
                    },
                    {
                        value: "red",
                        label: "Red Theme"
                    },
                    {
                        value: "yellow",
                        label: "Yellow Theme"
                    },
                    {
                        value: "green",
                        label: "Green Theme"
                    },
                    {
                        value: "purple",
                        label: "Purple Theme"
                    }
                ],

                openEventModal: false,

                initDate() {
                    let today = new Date();
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                },

                isToday(date) {
                    const today = new Date();
                    const d = new Date(this.year, this.month, date);

                    return today.toDateString() === d.toDateString() ? true : false;
                },

                showEventModal(date) {
                    // open the modal
                    this.openEventModal = true;
                    this.event_date = new Date(this.year, this.month, date).toDateString();
                },

                addEvent() {
                    if (this.event_title == '') {
                        return;
                    }

                    this.events.push({
                        event_date: this.event_date,
                        event_title: this.event_title,
                        event_theme: this.event_theme
                    });

                    console.log(this.events);

                    // clear the form data
                    this.event_title = '';
                    this.event_date = '';
                    this.event_theme = 'blue';

                    //close the modal
                    this.openEventModal = false;
                },

                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                    // find where to start calendar day of week
                    let dayOfWeek = new Date(this.year, this.month).getDay();
                    let blankdaysArray = [];
                    for (var i = 1; i <= dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }

                    let daysArray = [];
                    for (var i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.blankdays = blankdaysArray;
                    this.no_of_days = daysArray;
                }
            }
        }
    </script>
@endsection
