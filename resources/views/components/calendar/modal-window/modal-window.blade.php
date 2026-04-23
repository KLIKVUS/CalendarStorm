<div class="fixed bottom-0 left-0 right-0 top-0 z-40 h-full w-full"
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
</div>
