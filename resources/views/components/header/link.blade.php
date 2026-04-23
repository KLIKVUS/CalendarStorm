@props([
    'route',
    'routeForLink' => $route,
    'activeClass' => 'text-blue-600 dark:text-blue-500',
    'inactiveClass' => 'text-gray-800 dark:text-neutral-200 hover:text-gray-500 dark:hover:text-neutral-400 focus:text-gray-500 dark:focus:text-neutral-400',
])

<a
    {{ $attributes->class([
        'p-2 flex items-center text-sm focus:outline-hidden gap-2',
        active_link($routeForLink, $activeClass, $inactiveClass),
    ]) }}
    href="{{ route($route) }}"
>
    {{ $slot }}
</a>
