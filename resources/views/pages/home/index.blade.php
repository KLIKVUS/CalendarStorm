@extends('layouts.base')

@section('page.title', 'Главная')

@section('content')
    <section class="mx-auto max-w-7xl px-6 py-24">
        <div class="text-center">
            <h1 class="text-5xl font-bold tracking-tight">
                Управляйте событиями в одном месте
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-lg text-gray-600 dark:text-gray-400">
                Создавайте календари, планируйте события, делитесь доступом
                с командой и следите за важными датами без лишней сложности.
            </p>

            <div class="mt-10 flex justify-center gap-4">
                @guest
                    <a
                        class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700"
                        href="{{ route('auth.register') }}"
                    >
                        Начать бесплатно
                    </a>

                    <a
                        class="rounded-lg border px-6 py-3 font-medium"
                        href="{{ route('auth.login') }}"
                    >
                        Войти
                    </a>
                @else
                    <a
                        class="rounded-lg bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700"
                        href="{{ route('profile.index', auth()->user()) }}"
                    >
                        Перейти к календарям
                    </a>
                @endguest
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-6 py-20">
        <div class="grid gap-6 md:grid-cols-3">
            <div class="rounded-xl border p-6">
                <h3 class="text-lg font-semibold">
                    Несколько календарей
                </h3>

                <p class="mt-3 text-gray-600 dark:text-gray-400">
                    Разделяйте личные, рабочие и командные расписания.
                </p>
            </div>

            <div class="rounded-xl border p-6">
                <h3 class="text-lg font-semibold">
                    Совместная работа
                </h3>

                <p class="mt-3 text-gray-600 dark:text-gray-400">
                    Приглашайте участников и управляйте правами доступа.
                </p>
            </div>

            <div class="rounded-xl border p-6">
                <h3 class="text-lg font-semibold">
                    Гибкое планирование
                </h3>

                <p class="mt-3 text-gray-600 dark:text-gray-400">
                    Создавайте события на часы, дни или целые периоды времени.
                </p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-6 py-20 text-center">
        <h2 class="text-3xl font-bold">
            Всё необходимое для планирования
        </h2>

        <p class="mt-4 text-gray-600 dark:text-gray-400">
            Храните события, отслеживайте важные даты и делитесь календарями
            с другими пользователями.
        </p>

        @guest
            <a
                class="mt-8 inline-block rounded-lg bg-blue-600 px-8 py-3 font-medium text-white hover:bg-blue-700"
                href="{{ route('auth.register') }}"
            >
                Создать аккаунт
            </a>
        @endguest
    </section>
@endsection
