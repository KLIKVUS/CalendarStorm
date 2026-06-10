@extends('layouts.base')

@section('page.title', __('Профиль'))

@section('content')
    <div
        class="flex flex-col gap-5 md:h-[75vh] md:flex-row"
        x-data="{
            userCalendarConfig: {
                calendarId: {{ $calendar?->id ?? $calendars->first()?->id }},
                calendarName: '{{ $calendar?->name ?? $calendars->first()?->name ?? '' }}',

                rights_of_the_current_user: {
                    is_user_can_update: @js($calendar?->is_user_can_update ?? $calendars->first()?->is_user_can_update ?? false),
                    is_user_can_delete: @js($calendar?->is_user_can_delete ?? $calendars->first()?->is_user_can_delete ?? false),
                    is_user_can_create_events: @js($calendar?->is_user_can_create_events ?? $calendars->first()?->is_user_can_create_events ?? false),
                },

                get eventsUrl() {
                    return `/calendars/${this.calendarId}/events`;
                }
            },
        }"
    >
        <div class="flex flex-col gap-3 md:w-2/5">
            <div class="flex flex-col items-center justify-center gap-2">
                <x-tabler-user class="inline-block size-20 rounded-3xl ring-2 ring-gray-400" />

                <h2 class="text-center text-2xl font-bold sm:text-3xl">
                    {{ $user->login }}#{{ $user->id }}
                </h2>
            </div>

            <x-divider.with-text text="Календари пользователя" />

            @if ($user->id == auth()->id())
                <x-buttons.base-button
                    class="border-2 border-gray-400 py-2"
                    @click="$store.modal.OpenModal('CreateCalendar')"
                >
                    Создать календарь
                </x-buttons.base-button>
            @endif

            <x-profile.user-calendars-list
                :calendars="$calendars"
                :userId="$user->id"
            />
        </div>

        @if (count($calendars->items()))
            <div class="flex h-[50vh] md:h-auto md:basis-full">
                @include('includes.calendar', ['xData' => 'UserCalendar(userCalendarConfig)'])
            </div>
        @endif
    </div>

    <x-modal.for-calendar />
@endsection
