<div
    {{ $attributes->class(['min-h-28', 'select-none', 'sm:min-h-40']) }}
    x-data="{ isHovered: false }"
>
    {{ $slot }}
</div>
