@props(['text'])

<button
    type="submit"
    {{ $attributes->class(['rounded-lg border-2 border-green-700 bg-gray-800 px-4 py-2 font-semibold text-white shadow-sm hover:bg-gray-700 disabled:pointer-events-none disabled:border-red-700 disabled:opacity-50']) }}
    {{ $attributes }}
>{{ __($text) }}</button>
