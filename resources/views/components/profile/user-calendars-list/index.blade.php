<div class="flex min-h-0 basis-full flex-col items-center gap-4">
    <ul
        class="max-h-[20vh] min-h-0 basis-full space-y-2 overflow-y-auto overflow-x-clip text-center md:max-h-none">
        @foreach ($calendars as $calendar)
            <li>
                <h4 class="text-sm font-medium leading-loose">
                    {{ $calendar->name }}
                </h4>

                <x-profile.user-calendars-list.btns-group :calendar="$calendar" :userId="$userId" />
            </li>
        @endforeach
    </ul>

    {{ $calendars->links('components.pagination.index') }}
</div>
