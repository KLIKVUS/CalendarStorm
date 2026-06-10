@extends('layouts.base')

@section('page.title', $title)

@section('content')
    <div class="flex min-h-[calc(100vh-8rem)] items-center justify-center">
        <div
            class="w-full max-w-md space-y-8"
            x-data="{ tab: '{{ $tab }}' }"
        >
            {{-- Табы переключения --}}
            {{-- <div class="flex border-b border-gray-200 dark:border-gray-700">
                <button
                    class="-mb-px flex-1 py-4 font-medium transition-all duration-200"
                    @click="tab='login'"
                    :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'login', 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300': tab !== 'login' }"
                >
                    <span>{{ __('Вход') }}</span>
                </button>
                <button
                    class="-mb-px flex-1 py-4 font-medium transition-all duration-200"
                    @click="tab='register'"
                    :class="{
                        'border-b-2 border-blue-500 text-blue-600': tab === 'register',
                        'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300': tab !== 'register'
                    }"
                >
                    <span>{{ __('Регистрация') }}</span>
                </button>
            </div> --}}

            {{-- Форма входа --}}
            <div
                class="animate-fade-in mt-6"
                style="display: block;"
                x-show="tab === 'login'"
            >
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Вход в аккаунт') }}</h2>
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Не имеете аккаунта? ') }}
                        <a
                            class="font-medium text-blue-600 transition-colors hover:text-blue-500 dark:text-blue-400"
                            href="{{ route('auth.register') }}"
                        >
                            {{ __('Зарегистрируйтесь') }}
                        </a>
                    </p>
                </div>

                <form
                    class="mt-8 space-y-6"
                    action="{{ route('auth.login') }}"
                    method="POST"
                >
                    @csrf

                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            for="login"
                        >
                            {{ __('Логин') }}
                        </label>
                        <input
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-base text-gray-900 placeholder-gray-400 transition-all duration-200 autofill:shadow-[inset_0_0_0px_1000px_rgb(59,130,246)] focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500"
                            id="login"
                            name="login"
                            type="text"
                            value="{{ old('login') }}"
                            required
                            autocomplete="username"
                        >
                        @error('login')
                            <p
                                class="mt-2 text-sm text-red-600 dark:text-red-400"
                                role="alert"
                            >{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            for="password"
                        >
                            {{ __('Пароль') }}
                        </label>
                        <div class="relative">
                            <input
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-base text-gray-900 placeholder-gray-400 transition-all duration-200 autofill:shadow-[inset_0_0_0px_1000px_rgb(59,130,246)] focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500"
                                id="password"
                                name="password"
                                type="password"
                                required
                                autocomplete="current-password"
                            >
                            {{-- Иконка глаза для показа пароля (можно добавить позже) --}}
                        </div>
                        @error('password')
                            <p
                                class="mt-2 text-sm text-red-600 dark:text-red-400"
                                role="alert"
                            >{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 transition-colors duration-200 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                id="remember"
                                name="remember"
                                type="checkbox"
                                value="1"
                            >
                            <label
                                class="ml-2 block cursor-pointer text-sm text-gray-900 dark:text-gray-300"
                                for="remember"
                            >
                                {{ __('Запомнить меня') }}
                            </label>
                        </div>

                        <div class="text-sm">
                            {{-- TODO: Сброс пароля --}}
                        </div>
                    </div>

                    <div>
                        <button
                            class="flex w-full justify-center rounded-lg bg-blue-600 px-4 py-3 text-sm font-medium text-white shadow-sm transition-all hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800/50"
                            type="submit"
                        >
                            {{ __('Войти') }}
                        </button>
                    </div>

                    @if ($errors->has('login') || $errors->has('password'))
                        <p class="text-sm text-red-600 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <p class="list-inside list-disc">{{ $error }}</p>
                            @endforeach
                        </p>
                    @endif
                </form>
            </div>

            {{-- Форма регистрации --}}
            <div
                class="animate-fade-in mt-6"
                style="display: none;"
                x-show="tab === 'register'"
            >
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Регистрация') }}</h2>
                    <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Уже имеете аккаунт? ') }}
                        <a
                            class="font-medium text-blue-600 transition-colors hover:text-blue-500 dark:text-blue-400"
                            href="{{ route('auth.login') }}"
                        >
                            {{ __('Войдите') }}
                        </a>
                    </p>
                </div>

                <form
                    class="mt-8 space-y-6"
                    action="{{ route('auth.register') }}"
                    method="POST"
                >
                    @csrf

                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            for="register_login"
                        >
                            {{ __('Логин') }}
                        </label>
                        <input
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-base text-gray-900 placeholder-gray-400 transition-all duration-200 autofill:shadow-[inset_0_0_0px_1000px_rgb(59,130,246)] focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500"
                            id="register_login"
                            name="login"
                            type="text"
                            required
                            autocomplete="username"
                        >
                        @error('login')
                            <p
                                class="mt-2 text-sm text-red-600 dark:text-red-400"
                                role="alert"
                            >{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            for="register_password"
                        >
                            {{ __('Пароль') }}
                        </label>
                        <div class="relative">
                            <input
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-base text-gray-900 placeholder-gray-400 transition-all duration-200 autofill:shadow-[inset_0_0_0px_1000px_rgb(59,130,246)] focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500"
                                id="register_password"
                                name="password"
                                type="password"
                                required
                                autocomplete="new-password"
                                minlength="8"
                            >
                            {{-- Подсказка о сложности пароля --}}
                        </div>
                        @error('password')
                            <p
                                class="mt-2 text-sm text-red-600 dark:text-red-400"
                                role="alert"
                            >{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button
                            class="flex w-full justify-center rounded-lg bg-blue-600 px-4 py-3 text-sm font-medium text-white shadow-sm transition-all hover:bg-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800/50"
                            type="submit"
                        >
                            {{ __('Зарегистрироваться') }}
                        </button>
                    </div>

                    @if ($errors->has('login') || $errors->has('password'))
                        <p class="text-sm text-red-600 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <p class="list-inside list-disc">{{ $error }}</p>
                            @endforeach
                        </p>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection
