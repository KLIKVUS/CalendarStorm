@props(['for' => null, 'text' => ''])
<p
    class="{{ $for ? '' : 'error-msg' }} mt-1 text-sm text-red-500"
    @if ($for) x-text="errors.{{ $for }}" @endif
>{{ $text }}</p>
