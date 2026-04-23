@props([
    "size" => "base",
    "svg",
])

<i {{ $attributes->merge(["class" => "ti ti-$svg text-$size"]) }}>
    {{ $slot }}
</i>
