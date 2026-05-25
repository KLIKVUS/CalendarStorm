@push('head.js')
    <script>
        window.translations = @json([
            'calendar' => __('calendar'),
        ]);
    </script>
@endpush

<div
    class="h-full w-full overflow-clip rounded-lg bg-gray-50 shadow-lg shadow-slate-200 dark:bg-gray-800 dark:shadow-slate-900 flex flex-col"
    x-data="GlobalCalendar"
    x-cloak
>
    <x-calendar.header />
    <x-calendar.calendar-structure />
</div>
