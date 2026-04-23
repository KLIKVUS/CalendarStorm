<div
    x-collapse.duration.500ms
    x-show="$store.breakpoints.up('md') || {{ $whenCollapse }}"
    @mousedown.outside="{{ $whenCollapse }} = false"
    {{ $attributes->class([
        'max-h-[75vh]',
    ]) }}
>
    {{ $slot }}
</div>
