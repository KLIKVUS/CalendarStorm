<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-cloak
    x-data="{ darkMode: $persist(false) }"
    :class="{ 'dark': darkMode === true }">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1">

    <title>@yield('page.title', config('app.name'))</title>

    <!-- Fonts -->

    <!-- Styles -->
    @vite(['resources/sass/app.scss'])

    <!-- Js -->
    @vite(['resources/js/app.js'])
    @stack('head.js')
</head>

<body class="dark:bg-gray-900 dark:text-white container mx-auto flex min-h-screen flex-col px-5 antialiased">
    <header>
        @include('includes.header')
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer>
        @include('includes.footer')
    </footer>
</body>

</html>
