<div class="flex flex-wrap items-stretch gap-1" x-data="{ curYear: new Date().getFullYear(), curMonth: new Date().getMonth() }">
    <x-buttons.base-button x-on:click="calendarService.SwitchToPreviousMonth()">
        <x-tabler-caret-left-filled class="size-5" />
    </x-buttons.base-button>
    <x-buttons.base-button x-bind:class="{ 'opacity-25': calendarService.IsSelectedMonth(curYear, curMonth) }"
        x-bind:disabled="calendarService.IsSelectedMonth(curYear, curMonth) ? true : false" x-on:click="calendarService.SwitchToCurrentMonth()">
        {{ __("Today") }}
    </x-buttons.base-button>
    <x-buttons.base-button x-on:click="calendarService.SwitchToNextMonth()">
        <x-tabler-caret-right-filled class="size-5" />
    </x-buttons.base-button>
</div>
