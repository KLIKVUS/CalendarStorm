@extends('layouts.base')

@section('page.title', __('Профиль'))

@section('content')
    <div class="flex flex-col gap-5 md:flex-row md:h-[75vh]">
        <div class="flex flex-col gap-3 md:w-2/5">
            <div class="flex flex-col items-center justify-center gap-2">
                <x-tabler-user class="inline-block size-20 rounded-3xl ring-2 ring-gray-400" />

                <h2 class="text-center text-2xl font-bold sm:text-3xl">
                    {{ Auth::user()->login }}#{{ Auth::user()->id }}
                </h2>
            </div>

            <x-divider.with-text text="Календари пользователя" />

            <x-profile.user-calendars-list />
        </div>

        <div class="flex md:basis-full h-[50vh] md:h-auto">
            @include('includes.calendar')
        </div>
    </div>
@endsection
