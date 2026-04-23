<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-cloak
    x-data="localUserSettings"
    :class="{ dark: dark_mode === true, light: dark_mode === false }">

<head class="[&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page.title', config('app.name'))</title>

    <!-- Styles -->
    @vite(['resources/sass/app.scss'])

    <!-- Js -->
    @vite(['resources/ts/app.ts'])
    @stack('head.js')
</head>

<body class="dark:bg-gray-900 dark:text-white md:mx-4 flex min-h-screen flex-col bg-slate-100 antialiased transition-[background-color,margin] duration-200 ease-in">
    @include('includes.header')

    @include('includes.main')

    @include('includes.footer')
</body>

</html>
