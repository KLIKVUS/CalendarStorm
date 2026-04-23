<div
    {{ $attributes->class(['flex', 'flex-wrap', 'divide-x-2', 'border-t-2', 'bg-gray-50', 'dark:divide-gray-900', 'dark:border-gray-900', 'dark:bg-gray-800', 'h-10']) }}>
    <template
        x-for="(day, dayIndex) in dayNames"
        :key="dayIndex"
        hidden
    >
        <x-calendar.day-names.day />
    </template>
</div>
